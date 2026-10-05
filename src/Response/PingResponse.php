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
        $payload = ResponsePayload::fromHttpResult($httpResult);
        $result = $payload->requiredString('result');
        if ($result !== 'pong') {
            throw new ResponsePayloadException('Invalid Ping response', '$.result');
        }

        return new self(
            $result,
            $payload->optionalArray('webhook_response', [])
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
}
