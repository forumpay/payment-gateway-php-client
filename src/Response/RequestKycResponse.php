<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class RequestKycResponse
{
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        return new self(
            $responseJson['status'],
        );
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
