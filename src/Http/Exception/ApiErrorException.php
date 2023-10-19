<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

class ApiErrorException extends AbstractApiException
{
    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        array $responseJson
    ) {
        parent::__construct(
            $httpMethod,
            $uri,
            $callParameters,
            $responseJson['err'],
            $responseJson['errCode'] ?? null,
            $responseJson['additional'] ?? null,
        );
    }
}
