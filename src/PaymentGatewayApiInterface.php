<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\ApiExceptionInterface;
use ForumPay\PaymentGateway\PHPClient\Response\CancelPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyListResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetRateResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetRatesResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactionsResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetWalletAppsResponse;
use ForumPay\PaymentGateway\PHPClient\Response\RequestKycResponse;
use ForumPay\PaymentGateway\PHPClient\Response\StartPaymentResponse;

interface PaymentGatewayApiInterface
{
    /**
     * @throws ApiExceptionInterface
     */
    public function getRate(
        string $posId,
        string $invoiceCurrency,
        string $invoiceAmount,
        string $currency,
        string $acceptZeroConfirmations,
        ?string $requireKytForConfirmation,
        ?string $walletAppId,
        ?string $sid,
        ?string $user = null
    ): GetRateResponse;

    /**
     * Get rates for multiple cryptocurrencies
     *
     * @throws ApiExceptionInterface
     */
    public function getRates(
        string $posId,
        string $invoiceCurrency,
        string $invoiceAmount,
        string $currencies,
        ?string $acceptZeroConfirmations = null,
        ?string $requireKytForConfirmation = null,
        ?string $walletAppId = null,
        ?string $sid = null,
        ?string $user = null
    ): GetRatesResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function startPayment(
        string $posId,
        string $invoiceCurrency,
        string $paymentId,
        string $invoiceAmount,
        string $currency,
        ?string $referenceNo,
        string $acceptZeroConfirmations,
        ?string $payerIpAddress,
        ?string $payerEmail,
        ?string $payerId,
        string $autoAcceptUnderpayment,
        string $autoAcceptUnderpaymentMin,
        string $autoAcceptOverpayment,
        ?string $payerUserAgent,
        ?string $walletAppId,
        ?string $sid,
        ?string $requireKytForConfirmation,
        ?string $user = null,
        ?string $payerKycPin = null,
        string $autoAcceptLatePayment = 'false',
        ?string $webhookUrl = null,
        ?string $onSuccessRedirectUrl = null,
        ?string $onFailureRedirectUrl = null,
        ?string $autoAcceptOverpaymentMax = null
    ): StartPaymentResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function checkPayment(
        string $posId,
        string $currency,
        string $paymentId,
        string $address,
        ?string $user = null
    ): CheckPaymentResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function getTransactions(
        ?int $offset = null,
        ?int $limit = null,
        ?string $referenceNo = null,
        ?string $user = null
    ): GetTransactionsResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function cancelPayment(
        string $posId,
        string $currency,
        string $paymentId,
        string $address,
        string $reason,
        string $comment,
        ?string $user = null
    ): CancelPaymentResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function getCurrencyList(
        string $invoiceCurrency,
        ?string $user = null
    ): GetCurrencyListResponse;

    /**
     * @throws ApiExceptionInterface
     */
    public function requestKyc(
        string $email,
        ?string $user = null
    ): RequestKycResponse;

    /**
     * Get a list of all possible wallet apps
     *
     * @throws ApiExceptionInterface
     */
    public function getWalletApps(): GetWalletAppsResponse;
}
