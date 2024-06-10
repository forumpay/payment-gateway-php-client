<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

class ApiErrorException extends AbstractApiException
{
    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        string $cfRayId,
        array $responseJson
    ) {
        parent::__construct(
            $httpMethod,
            $uri,
            $callParameters,
            $cfRayId,
            $responseJson['err'],
            $responseJson['err_code'] ?? null,
            $responseJson['additional'] ?? null,
        );
    }
}
