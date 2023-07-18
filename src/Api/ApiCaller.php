<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Api;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\ApiExceptionInterface;
use ForumPay\PaymentGateway\PHPClient\Http\HttpClientInterface;
use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Logging\LoggerTrait;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class ApiCaller
{
    use LoggerTrait;

    private string $paymentGatewayUri;

    private string $apiUser;

    private string $apiSecret;

    private HttpClientInterface $httpClient;

    private ?LoggerInterface $logger;

    public function __construct(
        string $paymentGatewayUri,
        string $apiUser,
        string $apiSecret,
        HttpClientInterface $httpClient,
        ?LoggerInterface $logger = null
    ) {
        $this->paymentGatewayUri = trim(rtrim($paymentGatewayUri, '/'));
        self::validatePaymentGatewayUri($this->paymentGatewayUri);
        $this->apiUser = trim($apiUser);
        $this->apiSecret = trim($apiSecret);
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function get(string $action, array $parameters = []): HttpResult
    {
        $this->logInfo('Executing GET call', [
            'uri' => $this->getUri($action),
            'user' => $this->apiUser,
            'parameters' => $parameters,
        ]);

        return $this->call('GET', $action, $parameters);
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function post(string $action, array $parameters = []): HttpResult
    {
        $this->logInfo('Executing POST call', [
            'uri' => $this->getUri($action),
            'user' => $this->apiUser,
            'parameters' => $parameters,
        ]);

        return $this->call('POST', $action, $parameters);
    }

    private function call(string $method, string $action, array $parameters = []): HttpResult
    {
        return $this->httpClient->call(
            $method,
            $this->getUri($action),
            $this->apiUser,
            $this->apiSecret,
            $parameters
        );
    }

    private static function validatePaymentGatewayUri(string $paymentGatewayUri): void
    {
        if (empty($paymentGatewayUri)) {
            throw new InvalidArgumentException(sprintf('Empty $paymentGatewayUri passed to %s\'s constructor', __CLASS__));
        }
    }

    private function getUri(string $action): string
    {
        return UriParser::getUri($this->paymentGatewayUri, $action);
    }
}
