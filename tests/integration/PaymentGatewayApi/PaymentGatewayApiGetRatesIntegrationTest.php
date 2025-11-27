<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\GetRatesResponse;
use TypeError;

class PaymentGatewayApiGetRatesIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_RATES_CALL_PARAMETERS = [
        'pos_id' => 'web',
        'invoice_currency' => 'USD',
        'invoice_amount' => '100.00',
        'currencies' => 'BTC,ETH,USDT',
        'accept_zero_confirmations' => null,
        'require_kyt_for_confirmation' => null,
        'wallet_app_id' => null,
        'sid' => 'a1b2c3d4-5e6f-7a8b-9c0d-1e2f3a4b5c6d',
    ];

    public function testItCallsGetRates()
    {
        $fixtures = self::getFixturesJson('getRatesResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATES,
            self::GET_RATES_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getRates(...array_values(self::GET_RATES_CALL_PARAMETERS));

        self::assertInstanceOf(GetRatesResponse::class, $response);

        self::assertEquals('c55a45a5-8ddf-56f4-b9ed-7c59439ea9e6', $response->getPaymentId());
        self::assertEquals('100.00', $response->getInvoiceAmount());
        self::assertEquals('USD', $response->getInvoiceCurrency());
        self::assertEquals('a1b2c3d4-5e6f-7a8b-9c0d-1e2f3a4b5c6d', $response->getSid());

        $currencies = $response->getCurrencies();
        self::assertIsArray($currencies);
        self::assertCount(3, $currencies);

        // Assert BTC currency details
        self::assertEquals('BTC', $currencies[0]['currency']);
        self::assertEquals('42500.5432', $currencies[0]['rate']);
        self::assertEquals('0.00235294', $currencies[0]['amount_exchange']);
        self::assertEquals('0.00001500', $currencies[0]['network_processing_fee']);
        self::assertEquals('0.00236794', $currencies[0]['amount']);
        self::assertEquals('Less than 2 minutes', $currencies[0]['wait_time']);
        self::assertEquals('0.00008500', $currencies[0]['fast_transaction_fee']);
        self::assertEquals('BTC/kB', $currencies[0]['fast_transaction_fee_currency']);

        // Assert ETH currency details
        self::assertEquals('ETH', $currencies[1]['currency']);
        self::assertEquals('2250.7890', $currencies[1]['rate']);

        // Assert USDT currency details
        self::assertEquals('USDT', $currencies[2]['currency']);
        self::assertEquals('1.0000', $currencies[2]['rate']);
    }

    public function testItCallsGetRatesWithNullSid()
    {
        $fixtures = self::getFixturesJson('getRatesResponse');
        $fixtures['sid'] = null;
        $this->setMockedApiResponse($fixtures);

        $callParameters = self::GET_RATES_CALL_PARAMETERS;
        $callParameters['sid'] = null;

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATES,
            $callParameters
        );

        $response = $paymentGatewayApi->getRates(...array_values($callParameters));

        self::assertInstanceOf(GetRatesResponse::class, $response);
        self::assertNull($response->getSid());
    }

    public function testItHandlesEmptyCurrenciesArray()
    {
        $fixtures = self::getFixturesJson('getRatesResponse');
        $fixtures['currencies'] = [];
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATES,
            self::GET_RATES_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getRates(...array_values(self::GET_RATES_CALL_PARAMETERS));

        self::assertInstanceOf(GetRatesResponse::class, $response);
        self::assertIsArray($response->getCurrencies());
        self::assertCount(0, $response->getCurrencies());
    }

    public function testItReturnsCorrectArrayFromToArray()
    {
        $fixtures = self::getFixturesJson('getRatesResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_RATES,
            self::GET_RATES_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getRates(...array_values(self::GET_RATES_CALL_PARAMETERS));

        $array = $response->toArray();

        self::assertIsArray($array);
        self::assertArrayHasKey('payment_id', $array);
        self::assertArrayHasKey('invoice_amount', $array);
        self::assertArrayHasKey('invoice_currency', $array);
        self::assertArrayHasKey('sid', $array);
        self::assertArrayHasKey('currencies', $array);

        self::assertEquals('c55a45a5-8ddf-56f4-b9ed-7c59439ea9e6', $array['payment_id']);
        self::assertEquals('100.00', $array['invoice_amount']);
        self::assertEquals('USD', $array['invoice_currency']);
        self::assertEquals('a1b2c3d4-5e6f-7a8b-9c0d-1e2f3a4b5c6d', $array['sid']);
        self::assertIsArray($array['currencies']);
        self::assertCount(3, $array['currencies']);
    }
}
