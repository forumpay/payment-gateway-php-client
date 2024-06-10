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
        return new self(
            array_map(
                fn (array $currency) => Currency::createFromArray($currency),
                $httpResult->getResponse()
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
