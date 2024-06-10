<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class PingResponse
{
    private string $result;

    public function __construct(string $result)
    {
        $this->result = $result;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        if (! self::isResponseValid($responseJson)) {
            throw new \RuntimeException('Invalid Ping response');
        }

        return new self(
            $responseJson['result'],
        );
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function toArray(): array
    {
        return [
            'result' => $this->result,
        ];
    }

    private static function isResponseValid(?array $response): bool
    {
        return $response && isset($response['result']) && $response['result'] === 'pong';
    }
}
