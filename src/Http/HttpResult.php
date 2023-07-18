<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http;

class HttpResult
{
    private string $httpMethod;

    private string $uri;

    private array $callParameters;

    private array $response;

    private array $info;

    private ?string $error;

    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        array $response,
        array $info = [],
        ?string $error = null
    ) {
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
        $this->callParameters = $callParameters;
        $this->response = $response;
        $this->info = $info;
        $this->error = $error;
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

    public function getResponse(): array
    {
        return $this->response;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
