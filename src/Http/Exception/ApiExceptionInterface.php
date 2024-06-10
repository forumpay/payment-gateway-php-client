<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

use Throwable;

interface ApiExceptionInterface extends Throwable
{
    public function getHttpMethod(): string;

    public function getUri(): string;

    public function getCallParameters(): array;

    public function getCfRayId(): string;

    public function getErrorCode(): ?string;

    public function getAdditionalData(): ?array;
}
