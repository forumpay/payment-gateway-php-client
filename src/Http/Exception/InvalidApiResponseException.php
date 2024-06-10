<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

class InvalidApiResponseException extends AbstractApiException
{
    private array $curlInfo;

    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        string $cfRayId,
        string $curlError,
        int $curlErrno,
        array $curlInfo
    ) {
        $this->curlInfo = $curlInfo;
        parent::__construct($httpMethod, $uri, $callParameters, $cfRayId, $curlError, (string) $curlErrno);
    }

    public function getCurlInfo(): array
    {
        return $this->curlInfo;
    }
}
