<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient;

use ForumPay\PaymentGateway\PHPClient\Api\ApiCaller;
use ForumPay\PaymentGateway\PHPClient\Http\Exception\ApiExceptionInterface;
use ForumPay\PaymentGateway\PHPClient\Http\HttpClient;
use ForumPay\PaymentGateway\PHPClient\Http\HttpClientInterface;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\CancelPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\Factory\ResponseFactory;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyListResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetRateResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactionsResponse;
use ForumPay\PaymentGateway\PHPClient\Response\RequestKycResponse;
use ForumPay\PaymentGateway\PHPClient\Response\StartPaymentResponse;
use Psr\Log\LoggerInterface;

class PaymentGatewayApi implements PaymentGatewayApiInterface
{
    private const DEFAULT_LOCALE = 'en-GB';

    private ApiCaller $apiCaller;

    private string $locale;

    private ResponseFactory $responseFactory;

    public function __construct(
        string $paymentGatewayUri,
        string $apiUser,
        string $apiSecret,
        string $userAgentApplicationIdentifier,
        string $locale = self::DEFAULT_LOCALE,
        ?HttpClientInterface $httpClient = null,
        ?LoggerInterface $logger = null
    ) {
        $httpClient = $httpClient ?? new HttpClient($userAgentApplicationIdentifier);
        $httpClient->setLogger($logger);
        $this->apiCaller = new ApiCaller(
            $paymentGatewayUri,
            $apiUser,
            $apiSecret,
            $httpClient,
            $logger
        );
        $this->locale = $locale;
        $this->responseFactory = new ResponseFactory(
            $logger
        );
    }

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
    ): GetRateResponse {
        $httpResult = $this->apiCaller->get(
            Actions::GET_RATE,
            [
                'pos_id' => $posId,
                'invoice_currency' => $invoiceCurrency,
                'invoice_amount' => $invoiceAmount,
                'currency' => $currency,
                'accept_zero_confirmations' => $acceptZeroConfirmations,
                'require_kyt_for_confirmation' => $requireKytForConfirmation,
                'wallet_app_id' => $walletAppId,
                'sid' => $sid,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createGetRateResponse($httpResult);
    }

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
        ?string $user = null
    ): StartPaymentResponse {
        $httpResult = $this->apiCaller->post(
            Actions::START_PAYMENT,
            [
                'pos_id' => $posId,
                'invoice_currency' => $invoiceCurrency,
                'payment_id' => $paymentId,
                'invoice_amount' => $invoiceAmount,
                'currency' => $currency,
                'reference_no' => $referenceNo,
                'accept_zero_confirmations' => $acceptZeroConfirmations,
                'payer_ip_address' => $payerIpAddress,
                'payer_email' => $payerEmail,
                'payer_id' => $payerId,
                'auto_accept_underpayment' => $autoAcceptUnderpayment,
                'auto_accept_underpayment_min' => $autoAcceptUnderpaymentMin,
                'auto_accept_overpayment' => $autoAcceptOverpayment,
                'payer_user_agent' => $payerUserAgent,
                'wallet_app_id' => $walletAppId,
                'sid' => $sid,
                'require_kyt_for_confirmation' => $requireKytForConfirmation,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createStartPaymentResponse($httpResult);
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function checkPayment(
        string $posId,
        string $currency,
        string $paymentId,
        string $address,
        ?string $user = null
    ): CheckPaymentResponse {
        $httpResult = $this->apiCaller->get(
            Actions::CHECK_PAYMENT,
            [
                'pos_id' => $posId,
                'currency' => $currency,
                'payment_id' => $paymentId,
                'address' => $address,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createCheckPaymentResponse($httpResult);
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function getTransactions(
        ?int $offset = null,
        ?int $limit = null,
        ?string $referenceNo = null,
        ?string $user = null
    ): GetTransactionsResponse {
        $httpResult = $this->apiCaller->get(
            Actions::GET_TRANSACTIONS,
            [
                'offset' => $offset,
                'limit' => $limit,
                'reference_no' => $referenceNo,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createGetTransactionsResponse($httpResult);
    }

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
    ): CancelPaymentResponse {
        $httpResult = $this->apiCaller->get(
            Actions::CANCEL_PAYMENT,
            [
                'pos_id' => $posId,
                'currency' => $currency,
                'payment_id' => $paymentId,
                'address' => $address,
                'reason' => $reason,
                'comment' => $comment,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createCancelPaymentResponse($httpResult);
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function getCurrencyList(
        string $invoiceCurrency,
        ?string $user = null
    ): GetCurrencyListResponse {
        $httpResult = $this->apiCaller->get(
            Actions::GET_CURRENCY_LIST,
            [
                'invoice_currency' => $invoiceCurrency,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createGetCurrencyListResponse($httpResult);
    }

    /**
     * @throws ApiExceptionInterface
     */
    public function requestKyc(
        string $email,
        ?string $user = null
    ): RequestKycResponse {
        $httpResult = $this->apiCaller->post(
            Actions::REQUEST_KYC,
            [
                'email' => $email,
                'locale' => $this->locale,
            ] + ($user !== null ? [
                'user' => $user,
            ] : [])
        );

        return $this->responseFactory->createRequestKycResponse($httpResult);
    }
}
