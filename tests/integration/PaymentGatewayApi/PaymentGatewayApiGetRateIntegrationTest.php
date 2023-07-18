<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\GetRateResponse;
use TypeError;

class PaymentGatewayApiGetRateIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_RATE_CALL_PARAMETERS = [
        'pos_id' => 'web',
        'invoice_currency' => 'EUR',
        'invoice_amount' => '222.00',
        'currency' => 'BTC',
        'accept_zero_confirmations' => 'false',
        'require_kyt_for_confirmation' => 'false',
        'wallet_app_id' => null,
        'sid' => null,
    ];

    public function testItCallsGetRate()
    {
        $fixtures = self::getFixturesJson('getRateResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATE,
            self::GET_RATE_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getRate(...array_values(self::GET_RATE_CALL_PARAMETERS));

        self::assertInstanceOf(GetRateResponse::class, $response);

        self::assertEquals('EUR', $response->getInvoiceCurrency());
        self::assertEquals('222.00', $response->getInvoiceAmount());
        self::assertEquals('BTC', $response->getCurrency());
        self::assertEquals('20822.2343', $response->getRate());
        self::assertEquals('0.01066165', $response->getAmountExchange());
        self::assertEquals('0.00002875', $response->getNetworkProcessingFee());
        self::assertEquals('0.0106904', $response->getAmount());
        self::assertEquals('Less than 2 minutes', $response->getWaitTime());
        self::assertEquals(null, $response->getSid());
        self::assertEquals('0.00012724', $response->getFastTransactionFee());
        self::assertEquals('BTC/kB', $response->getFastTransactionFeeCurrency());
        self::assertEquals('b7fa25a4-7cce-45e3-a8cd-6b48328da8d5', $response->getPaymentId());
    }

    public function testItFailsGracefullyOnInvalidGetRateResponse()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATE,
            self::GET_RATE_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getRate(...array_values(self::GET_RATE_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
