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
        int $responseStatusCode
    ) {
        $this->responseStatusCode = $responseStatusCode;
        $message = sprintf('Call to Payment Gateway API responded with %d status code', $responseStatusCode);
        parent::__construct($httpMethod, $uri, $callParameters, $message);
    }

    public function getResponseStatusCode(): int
    {
        return $this->responseStatusCode;
    }
}
