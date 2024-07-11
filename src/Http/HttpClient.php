<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\ApiErrorException;
use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidApiResponseException;
use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseJsonException;
use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseStatusCodeException;
use ForumPay\PaymentGateway\PHPClient\Logging\LoggerTrait;
use ForumPay\PaymentGateway\PHPClient\PaymentGatewayApi;
use JsonException;
use Psr\Log\LoggerInterface;

class HttpClient implements HttpClientInterface
{
    use LoggerTrait;

    private const HEADERS = [
        'Cache-Control' => 'no-cache',
        'User-Agent' => 'PaymentGateway PHP Client',
        'Accept' => '*/*',
        'Connection' => 'keep-alive',
    ];

    private string $userAgentApplicationIdentifier;

    /** @var resource */
    private $curl;

    private ?LoggerInterface $logger;

    public function __construct(string $userAgentApplicationIdentifier = null)
    {
        $this->userAgentApplicationIdentifier = $userAgentApplicationIdentifier;
        $this->curl = curl_init();
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * {@inheritdoc}
     */
    public function call(
        string $method,
        string $uri,
        string $apiUser,
        string $apiSecret,
        array $parameters = []
    ): HttpResult {
        $cfRayHeader = '';
        curl_setopt($this->curl, CURLOPT_URL, self::parseUrl($uri, $method, $parameters));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($this->curl, CURLOPT_USERPWD, self::getAuthorization($apiUser, $apiSecret));
        curl_setopt($this->curl, CURLOPT_ENCODING, "");
        curl_setopt($this->curl, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$cfRayHeader) {
            $length = strlen($header);
            if (stripos($header, 'Cf-Ray:') === 0) {
                $cfRayHeader = trim(substr($header, 7));
            }
            return $length;
        });
        if (self::isPost($method)) {
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $parameters);
        }

        $requestId = uniqid();
        $this->logInfo('Executing cURL request', [
            'requestId' => $requestId,
            'url' => self::parseUrl($uri, $method, $parameters),
        ]);

        $response = curl_exec($this->curl);
        $info = curl_getinfo($this->curl);
        $curlError = curl_error($this->curl);
        $curlErrno = curl_errno($this->curl);

        $this->logInfo('cURL request finished', [
            'requestId' => $requestId,
            'response' => $response,
            'info' => $info,
            'error' => $curlError,
        ]);

        if ($response === false) {
            $this->logError('cURL request failed', [
                'requestId' => $requestId,
                'error' => $curlError,
                'errno' => $curlErrno,
            ]);
            $error = $curlError;
            if ($curlErrno === CURLE_OPERATION_TIMEDOUT || $curlErrno === CURLE_COULDNT_CONNECT) {
                $error = 'Timeout, please check your configuration';
            }

            throw new InvalidApiResponseException($method, $uri, $parameters, $cfRayHeader, $error, $curlErrno, $info);
        }

        if (HttpCodesValidator::isSuccess($info['http_code']) === false) {
            $errCode = $info['http_code'];
            $errMessage = "An error occurred";

            if ($errCode === 401) {
                $errMessage = 'No api key';
            } elseif ($errCode === 403) {
                $errMessage = 'API not reachable. Please contact support.';
            }

            try {
                $responseJson = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                if (is_array($responseJson) && array_key_exists('err', $responseJson)) {
                    $errCode = $responseJson['err_code'] ?? $errCode;
                    $errMessage = $responseJson['err'] ?? "Bad Request";
                }
            } catch (JsonException $e) {
                //
            }

            $this->logError('cURL request responded with error', [
                'requestId' => $requestId,
                'errCode' => $errCode,
                'error' => $errMessage,
                'additional' => $responseJson['additional'] ?? null,
            ]);

            throw new InvalidResponseStatusCodeException($method, $uri, $parameters, $cfRayHeader, $errCode, $errMessage);
        }

        try {
            $responseJson = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->logError('cURL request responded with invalid JSON', [
                'requestId' => $requestId,
                'response' => $response,
            ]);
            throw new InvalidResponseJsonException($method, $uri, $parameters, $cfRayHeader, $response);
        }

        if (is_array($responseJson) && array_key_exists('err', $responseJson)) {
            $this->logError('cURL request responded with Payment Gateway Webhost error', [
                'requestId' => $requestId,
                'error' => $curlError,
                'errCode' => $responseJson['err_code'] ?? null,
                'additional' => $responseJson['additional'] ?? null,
            ]);
            throw new ApiErrorException($method, $uri, $parameters, $cfRayHeader, $responseJson);
        }

        return new HttpResult($method, $uri, $parameters, $cfRayHeader, $responseJson, $info, $curlError);
    }

    private function getHeaders(): array
    {
        $headers = self::HEADERS;
        $headers['User-Agent'] .= ' ' . PaymentGatewayApi::VERSION;

        if ($this->userAgentApplicationIdentifier) {
            $headers['User-Agent'] .= '; ' . $this->userAgentApplicationIdentifier;
        }

        $headersForCurl = [];
        foreach ($headers as $header => $value) {
            $headersForCurl[] = "$header: $value";
        }

        return $headersForCurl;
    }

    public function setLogger(?LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    private static function parseUrl(string $uri, string $method, array $parameters): string
    {
        if (self::isPost($method) || empty($parameters)) {
            return $uri;
        } else {
            return $uri . '?' . http_build_query($parameters);
        }
    }

    private static function getAuthorization(string $apiUser, string $apiSecret): string
    {
        return $apiUser . ':' . $apiSecret;
    }

    private static function isPost(string $method): bool
    {
        return strtoupper($method) === 'POST';
    }
}
