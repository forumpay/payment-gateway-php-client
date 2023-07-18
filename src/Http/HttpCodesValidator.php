<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http;

class HttpCodesValidator
{
    public static function isSuccess(int $httpCode): bool
    {
        return $httpCode >= 200 &&
               $httpCode <= 299;
    }
}
