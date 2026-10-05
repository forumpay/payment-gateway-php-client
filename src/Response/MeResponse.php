<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class MeResponse
{
    private array $api;

    private array $account;

    public function __construct(array $api, array $account)
    {
        $this->api = $api;
        $this->account = $account;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $payload = ResponsePayload::fromHttpResult($httpResult);
        $api = $payload->requiredObject('api');
        $account = $payload->requiredObject('account');
        $api->requiredArray('permissions');
        $account->requiredString('id');

        return new self(
            $api->getData(),
            $account->getData()
        );
    }

    public function getApi(): array
    {
        return $this->api;
    }

    public function getApiPermissions(): array
    {
        return $this->api['permissions'];
    }

    public function getAccount(): array
    {
        return $this->account;
    }

    public function getAccountId(): string
    {
        return $this->account['id'];
    }

    public function toArray(): array
    {
        return [
            'api' => $this->api,
            'account' => $this->account,
        ];
    }
}
