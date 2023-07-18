<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Map;

class Actions
{
    public const GET_RATE = 'GetRate';

    public const START_PAYMENT = 'StartPayment';

    public const CHECK_PAYMENT = 'CheckPayment';

    public const GET_TRANSACTIONS = 'GetTransactions';

    public const CANCEL_PAYMENT = 'CancelPayment';

    public const GET_CURRENCY_LIST = 'GetCurrencyList';
}
