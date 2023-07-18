<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\CancelPaymentResponse;
use TypeError;

class PaymentGatewayApiCancelPaymentIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const CANCEL_PAYMENT_CALL_PARAMETERS = [
        'pos_id' => 'web',
        'currency' => 'BTC',
        'payment_id' => '3547ade6-cab8-4ce8-9ec9-c4fd7286363c',
        'address' => 'btc-32d7e90b1ff241ab81a36e22696c0047',
        'reason' => 'qr_code_problem',
        'comment' => 'no comment',
    ];

    public function testItCallsCancelPayment()
    {
        $fixtures = self::getFixturesJson('cancelPaymentResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::CANCEL_PAYMENT,
            self::CANCEL_PAYMENT_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->cancelPayment(...array_values(self::CANCEL_PAYMENT_CALL_PARAMETERS));

        self::assertInstanceOf(CancelPaymentResponse::class, $response);

        self::assertEquals(true, $response->isCancelled());
        self::assertEquals('Cancelled', $response->getStatus());
    }

    public function testItFailsGracefullyOnInvalidCancelPaymentResponse()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::CANCEL_PAYMENT,
            self::CANCEL_PAYMENT_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->cancelPayment(...array_values(self::CANCEL_PAYMENT_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
