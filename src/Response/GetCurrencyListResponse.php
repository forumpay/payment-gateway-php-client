<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyList\Currency;

class GetCurrencyListResponse
{
    private array $currencies;

    public function __construct(
        array $currencies = []
    ) {
        $this->currencies = $currencies;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $payload = ResponsePayload::fromHttpResult($httpResult);

        return new self(
            array_map(
                static function (ResponsePayload $currency): Currency {
                    return Currency::createFromArray($currency->getData(), $currency->getPath());
                },
                $payload->asList()
            )
        );
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function toArray(): array
    {
        return [
            'currencies' => array_map(
                fn (Currency $currency) => $currency->toArray(),
                $this->currencies
            ),
        ];
    }
}
