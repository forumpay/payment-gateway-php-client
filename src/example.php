<?php

//TODO: Created for manual testing purposes, remove before final release
declare(strict_types=1);

use ForumPay\PaymentGateway\PHPClient\PaymentGatewayApi;

//use Monolog\Handler\StreamHandler;
//use Monolog\Logger;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//$logger = new Logger(
//    'PaymentGatewayApi',
//    [new StreamHandler('./log.log', Logger::DEBUG)]
//);

$api = new PaymentGatewayApi(
    '',
    '',
    '',
    'User Identifier',
    'sl-SI',
    null,
//    $logger
);

//$getRateResponse = $api->getRate(
//    'web',
//    'EUR',
//    '222.00',
//    'BTC',
//    'false',
//    'false',
//    null,
//    null,
//    'b0ece610-4885-4881-93c5-9d55465ca8f3',
//);
//var_dump($getRateResponse->toArray());
//$paymentId = $getRateResponse->getPaymentId();


//$startPaymentResponse = $api->startPayment(
//    'web',
//    'EUR',
//    $paymentId,
//    '222.00',
//    'BTC',
//    null,
//    'false',
//    null, //'111.111.111.111',
//    null, //'mail@mail.com',
//    null,
//    'false',
//    '1.0',
//    'false',
//    null,
//    null,
//    null,
//    'false',
//    'b0ece610-4885-4881-93c5-9d55465ca8f3',
//);
//$address = $startPaymentResponse->getAddress();
//var_dump($startPaymentResponse->toArray());


//$checkPaymentResponse = $api->checkPayment(
//    'web',
//    'BTC',
//    $paymentId,
//    $address,
//    'b0ece610-4885-4881-93c5-9d55465ca8f3'
//);
//var_dump($checkPaymentResponse->toArray());


//$cancelPaymentResponse = $api->cancelPayment(
//    'web',
//    'BTC',
//    $paymentId,
//    $address,
//    'qr_code_problem',
//    'no comment',
//    'b0ece610-4885-4881-93c5-9d55465ca8f3'
//);
//var_dump($cancelPaymentResponse->toArray());


//$getTransactionsResponse = $api->getTransactions(
//    0,
//    10,
//    'b0ece610-4885-4881-93c5-9d55465ca8f3'
//);
//var_dump($getTransactionsResponse->toArray());


$getCurrencyList = $api->getCurrencyList(
    'EUR',
//    'b0ece610-4885-4881-93c5-9d55465ca8f3'
);
var_dump($getCurrencyList->toArray());
