<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class CancelPaymentResponse
{
    private bool $cancelled;

    private string $status;

    public function __construct(
        bool $cancelled,
        string $status
    ) {
        $this->cancelled = $cancelled;
        $this->status = $status;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        return new self(
            $responseJson['cancelled'],
            $responseJson['status']
        );
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'cancelled' => $this->cancelled,
            'status' => $this->status,
        ];
    }
}
