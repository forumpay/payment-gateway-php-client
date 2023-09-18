<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Api;

class UriParser
{
    public static function getUri(string $paymentGatewayUri, string $action): string
    {
        $uri = rtrim($paymentGatewayUri, '/');
        return "$uri/$action/";
    }
}
