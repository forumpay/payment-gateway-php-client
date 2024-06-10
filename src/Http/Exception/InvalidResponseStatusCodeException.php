<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

class InvalidResponseStatusCodeException extends AbstractApiException
{
    private int $responseStatusCode;

    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        string $cfRayId,
        int $responseStatusCode,
        ?string $message
    ) {
        $this->responseStatusCode = $responseStatusCode;
        $message = $message ?? sprintf('Call to Payment Gateway API responded with %d status code', $responseStatusCode);
        parent::__construct($httpMethod, $uri, $callParameters, $cfRayId, $message);
    }

    public function getResponseStatusCode(): int
    {
        return $this->responseStatusCode;
    }
}
