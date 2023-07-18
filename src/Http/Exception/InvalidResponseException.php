<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Http\Exception;

use Throwable;

class InvalidResponseException extends AbstractApiException
{
    private string $action;

    private array $response;

    public function __construct(
        string $httpMethod,
        string $uri,
        array $callParameters,
        string $action,
        array $response,
        Throwable $previous
    ) {
        $this->action = $action;
        $this->response = $response;
        parent::__construct($httpMethod, $uri, $callParameters, $previous->getMessage(), $previous);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getResponse(): array
    {
        return $this->response;
    }
}
