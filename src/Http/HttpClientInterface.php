<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\ApiExceptionInterface;
use Psr\Log\LoggerInterface;

interface HttpClientInterface
{
    /**
     * @param string $method either "GET" or "POST"
     * @param string $uri uri pointing to Payment Gateway Webhost api
     * @param string $apiUser Token "API User"
     * @param string $apiSecret Token "API Secret"
     * @param array $parameters Request query parameters
     * @return HttpResult nominally constructed as "new HttpResult(curl_exec($curlHandle), curl_getinfo($curlHandle), curl_error($curlHandle))"
     * @throws ApiExceptionInterface
     */
    public function call(
        string $method,
        string $uri,
        string $apiUser,
        string $apiSecret,
        array $parameters = []
    ): HttpResult;

    public function setLogger(
        ?LoggerInterface $logger
    ): void;
}
