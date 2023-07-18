<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPayment\Underpayment;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPaymentResponse;
use TypeError;

class PaymentGatewayApiCheckPaymentIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const CHECK_PAYMENT_CALL_PARAMETERS = [
        'pos_id' => 'web',
        'currency' => 'BTC',
        'payment_id' => '3547ade6-cab8-4ce8-9ec9-c4fd7286363c',
        'address' => 'btc-32d7e90b1ff241ab81a36e22696c0047',
    ];

    public function testItCallsCheckPayment()
    {
        $fixtures = self::getFixturesJson('checkPaymentResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::CHECK_PAYMENT,
            self::CHECK_PAYMENT_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->checkPayment(...array_values(self::CHECK_PAYMENT_CALL_PARAMETERS));

        self::assertInstanceOf(CheckPaymentResponse::class, $response);

        self::assertEquals(null, $response->getReferenceNo());
        self::assertEquals('2022-11-10 08:43:33', $response->getInserted());
        self::assertEquals('222.00', $response->getInvoiceAmount());
        self::assertEquals('Sell', $response->getType());
        self::assertEquals('EUR', $response->getInvoiceCurrency());
        self::assertEquals('0.01333323', $response->getAmount());
        self::assertEquals('1', $response->getMinConfirmations());
        self::assertEquals('1', $response->isAcceptZeroConfirmations());
        self::assertEquals('0', $response->isRequireKytForConfirmation());
        self::assertEquals('BTC', $response->getCurrency());
        self::assertEquals(false, $response->isConfirmed());
        self::assertEquals(null, $response->getConfirmedTime());
        self::assertEquals(null, $response->getReason());
        self::assertEquals(0.0000000, $response->getPayment());
        self::assertEquals(null, $response->getSid());
        self::assertEquals('0', $response->getConfirmations());
        self::assertEquals('fz7RCsx3Vl5VwijzFfVy1TssSiD8V9f2c7CAjKEKPzO7YvjfTHXFI5TT5lg22tDa', $response->getAccessToken());
        self::assertEquals('https://example-pgw.forumpay.com/pay?merchant_id=6a69b8ca-dc98-47d4-a33d-5edefee17f22&order_amount=222.00&order_currency=EUR&item_name=#checkPayment$web$3547ade6-cab8-4ce8-9ec9-c4fd7286363c$BTC$btc-32d7e90b1ff241ab81a36e22696c0047$6a69b8ca-dc98-47d4-a33d-5edefee17f22$fz7RCsx3Vl5VwijzFfVy1TssSiD8V9f2c7CAjKEKPzO7YvjfTHXFI5TT5lg22tDa', $response->getAccessUrl());
        self::assertEquals(null, $response->getWaitTime());
        self::assertEquals('Cancelled', $response->getStatus());
        self::assertEquals('0.0004361', $response->getUnconfirmedAmount());
        self::assertEquals('11.73', $response->getUnconfirmedInvoiceAmount());
        self::assertEquals(true, $response->isCancelled());
        self::assertEquals('2022-11-10 08:48:48', $response->getCancelledTime());
        self::assertEquals('<BR>Reference: web:3547ade6-cab8-4ce8-9ec9-c4fd7286363c<BR><DLINE><BR><CENTER>=== Cancelled ===</CENTER><BR><DLINE><BR><BR><CUT><LINE><BR>', $response->getPrintString());
        self::assertEquals('cancelled', $response->getState());

        self::assertInstanceOf(Underpayment::class, $response->getUnderpayment());

        self::assertEquals('btc-32d7e90b1ff241ab81a36e22696c0047', $response->getUnderpayment()->getAddress());
        self::assertEquals('0.01333323', $response->getUnderpayment()->getMissingAmount());
        self::assertEquals('https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-7382eb0b31a74b91bf1ebb099624f237&amount=0.0000100', $response->getUnderpayment()->getQr());
        self::assertEquals('https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-7382eb0b31a74b91bf1ebb099624f237', $response->getUnderpayment()->getQrAlt());
        self::assertEquals('https://example-api.forumpay.com/qr/?d=https%3A%2F%2Fexample-pgw.forumpay.com%2FsandboxWallet.transfer%3Fcurrency%3DBTC%26address%3Dbtc-7382eb0b31a74b91bf1ebb099624f237%26amount%3D0.0000100', $response->getUnderpayment()->getQrImg());
        self::assertEquals('https://example-api.forumpay.com/qr/?d=https%3A%2F%2Fexample-pgw.forumpay.com%2FsandboxWallet.transfer%3Fcurrency%3DBTC%26address%3Dbtc-7382eb0b31a74b91bf1ebb099624f237', $response->getUnderpayment()->getQrAltImg());
    }

    public function testItFailsGracefullyOnInvalidCheckPaymentResponse()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::CHECK_PAYMENT,
            self::CHECK_PAYMENT_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->checkPayment(...array_values(self::CHECK_PAYMENT_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
