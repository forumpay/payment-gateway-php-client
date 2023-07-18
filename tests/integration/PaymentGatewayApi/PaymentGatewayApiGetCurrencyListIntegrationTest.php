<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyList\Currency;
use ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyListResponse;
use TypeError;

class PaymentGatewayApiGetCurrencyListIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_CURRENCY_CALL_PARAMETERS = [
        'invoice_currency' => 'EUR',
    ];

    public function testItCallsGetCurrencyList()
    {
        $fixtures = self::getFixturesJson('getCurrencyListResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_CURRENCY_LIST,
            self::GET_CURRENCY_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getCurrencyList(...array_values(self::GET_CURRENCY_CALL_PARAMETERS));

        self::assertInstanceOf(GetCurrencyListResponse::class, $response);

        /** @var Currency $currency1 */
        /** @var Currency $currency2 */
        [$currency1, $currency2] = $response->getCurrencies();

        self::assertEquals('BTC', $currency1->getCurrency());
        self::assertEquals('Bitcoin', $currency1->getDescription());
        self::assertEquals('OK', $currency1->getStatus());
        self::assertEquals('1', $currency1->getZeroConfirmationsEnabled());
        self::assertEquals('EUR', $currency1->getCurrencyFiat());
        self::assertEquals('20822.2211', $currency1->getRate());
        self::assertEquals('OK', $currency1->getSellStatus());
        self::assertEquals('20822.2211', $currency1->getSellRate());
        self::assertEquals('OK', $currency1->getBuyStatus());
        self::assertEquals('20930.8791', $currency1->getBuyRate());
        self::assertEquals('0.12', $currency1->getSellMinInvoiceAmount());
        self::assertEquals('650.00', $currency1->getSellMaxInvoiceAmount());
        self::assertEquals('0.00000226', $currency1->getSellNetworkProcessingFee());
        self::assertEquals('0.66', $currency1->getBuyMinInvoiceAmount());
        self::assertEquals('99.00', $currency1->getBuyMaxInvoiceAmount());
        self::assertEquals('0.00003125', $currency1->getBuyNetworkProcessingFee());

        self::assertEquals('ETH', $currency2->getCurrency());
        self::assertEquals('Ethereum', $currency2->getDescription());
        self::assertEquals('OK', $currency2->getStatus());
        self::assertEquals('0', $currency2->getZeroConfirmationsEnabled());
        self::assertEquals('EUR', $currency2->getCurrencyFiat());
        self::assertEquals('1431.7278', $currency2->getRate());
        self::assertEquals('OK', $currency2->getSellStatus());
        self::assertEquals('1431.7278', $currency2->getSellRate());
        self::assertEquals('OK', $currency2->getBuyStatus());
        self::assertEquals('1439.5130', $currency2->getBuyRate());
        self::assertEquals('0.01', $currency2->getSellMinInvoiceAmount());
        self::assertEquals('650.00', $currency2->getSellMaxInvoiceAmount());
        self::assertEquals('0.00021463', $currency2->getSellNetworkProcessingFee());
        self::assertEquals('1.06', $currency2->getBuyMinInvoiceAmount());
        self::assertEquals('99.00', $currency2->getBuyMaxInvoiceAmount());
        self::assertEquals('0.00073165', $currency2->getBuyNetworkProcessingFee());
    }

    public function testItFailsGracefullyOnInvalidGetCurrencyListResponse()
    {
        $this->setMockedApiResponse([[
            'currency' => 0,
        ]]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_CURRENCY_LIST,
            self::GET_CURRENCY_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getCurrencyList(...array_values(self::GET_CURRENCY_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
