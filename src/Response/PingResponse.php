<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class PingResponse
{
    private string $result;

    private ?array $webhookResult;

    public function __construct(string $result, ?array $webhookResult = [])
    {
        $this->result = $result;
        $this->webhookResult = $webhookResult;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        if (! self::isResponseValid($responseJson)) {
            throw new \RuntimeException('Invalid Ping response');
        }

        return new self(
            $responseJson['result'],
            $responseJson['webhook_response'] ?? []
        );
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getWebhookResult(): array
    {
        return $this->webhookResult;
    }

    public function toArray(): array
    {
        return [
            'result' => $this->result,
            'webhook_response' => $this->webhookResult,
        ];
    }

    private static function isResponseValid(?array $response): bool
    {
        return $response && isset($response['result']) && $response['result'] === 'pong';
    }
}
