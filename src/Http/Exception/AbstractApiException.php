<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

use Exception;
use Throwable;

abstract class AbstractApiException extends Exception implements ApiExceptionInterface
{
    private string $httpMethod;

    private string $uri;

    private array $callParameters;

    private string $cfRayId;

    private ?string $errorCode;

    private ?array $additionalData;

    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        string $cfRayId,
        string $message,
        ?string $errorCode = null,
        ?array $additionalData = null,
        Throwable $previous = null
    ) {
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
        $this->callParameters = $callParameters;
        $this->cfRayId = $cfRayId;
        $this->errorCode = $errorCode;
        $this->additionalData = $additionalData;
        parent::__construct($message, 0, $previous);
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getCallParameters(): array
    {
        return $this->callParameters;
    }

    public function getCfRayId(): string
    {
        return $this->cfRayId;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function getAdditionalData(): ?array
    {
        return $this->additionalData;
    }
}
