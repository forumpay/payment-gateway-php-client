<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\Factory;

use Error;
use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Logging\LoggerTrait;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\CancelPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPaymentResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyListResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetRateResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetRatesResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactionsResponse;
use ForumPay\PaymentGateway\PHPClient\Response\GetWalletAppsResponse;
use ForumPay\PaymentGateway\PHPClient\Response\PingResponse;
use ForumPay\PaymentGateway\PHPClient\Response\RequestKycResponse;
use ForumPay\PaymentGateway\PHPClient\Response\StartPaymentResponse;
use Psr\Log\LoggerInterface;

class ResponseFactory
{
    use LoggerTrait;

    private ?LoggerInterface $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @throws InvalidResponseException
     */
    public function createPingResponse(HttpResult $httpResult): PingResponse
    {
        return self::createResponse(
            PingResponse::class,
            Actions::PING,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createGetRateResponse(HttpResult $httpResult): GetRateResponse
    {
        return self::createResponse(
            GetRateResponse::class,
            Actions::GET_RATE,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createGetRatesResponse(HttpResult $httpResult): GetRatesResponse
    {
        return self::createResponse(
            GetRatesResponse::class,
            Actions::GET_RATES,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createStartPaymentResponse(HttpResult $httpResult): StartPaymentResponse
    {
        return self::createResponse(
            StartPaymentResponse::class,
            Actions::START_PAYMENT,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createCheckPaymentResponse(HttpResult $httpResult): CheckPaymentResponse
    {
        return self::createResponse(
            CheckPaymentResponse::class,
            Actions::CHECK_PAYMENT,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createGetTransactionsResponse(HttpResult $httpResult): GetTransactionsResponse
    {
        return self::createResponse(
            GetTransactionsResponse::class,
            Actions::GET_TRANSACTIONS,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createCancelPaymentResponse(HttpResult $httpResult): CancelPaymentResponse
    {
        return self::createResponse(
            CancelPaymentResponse::class,
            Actions::CANCEL_PAYMENT,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createGetCurrencyListResponse(HttpResult $httpResult): GetCurrencyListResponse
    {
        return self::createResponse(
            GetCurrencyListResponse::class,
            Actions::GET_CURRENCY_LIST,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createRequestKycResponse(HttpResult $httpResult): RequestKycResponse
    {
        return self::createResponse(
            RequestKycResponse::class,
            Actions::REQUEST_KYC,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    public function createGetWalletAppsResponse(HttpResult $httpResult): GetWalletAppsResponse
    {
        return self::createResponse(
            GetWalletAppsResponse::class,
            Actions::GET_WALLET_APPS,
            $httpResult
        );
    }

    /**
     * @throws InvalidResponseException
     */
    private function createResponse(
        string $responseClass,
        string $action,
        HttpResult $httpResult
    ) {
        try {
            return $responseClass::createFromHttpResult($httpResult);
        } catch (Error $exception) {
            $this->logError('Calling "%s" endpoint failed due to invalid response', [
                'error' => $exception->getMessage(),
                'response' => $httpResult->getResponse(),
            ]);
            throw new InvalidResponseException($httpResult->getHttpMethod(), $httpResult->getUri(), $httpResult->getCallParameters(), $httpResult->getCfRayId(), $action, $httpResult->getResponse(), $exception);
        }
    }
}
