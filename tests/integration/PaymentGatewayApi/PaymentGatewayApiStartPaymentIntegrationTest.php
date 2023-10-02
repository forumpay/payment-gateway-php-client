<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\StartPaymentResponse;
use TypeError;

class PaymentGatewayApiStartPaymentIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const START_PAYMENT_CALL_PARAMETERS = [
        'pos_id' => 'web',
        'invoice_currency' => 'EUR',
        'payment_id' => '3547ade6-cab8-4ce8-9ec9-c4fd7286363c',
        'invoice_amount' => '222.00',
        'currency' => 'BTC',
        'reference_no' => null,
        'accept_zero_confirmations' => 'false',
        'payer_ip_address' => '111.111.111.111',
        'payer_email' => null,
        'payer_id' => null,
        'auto_accept_underpayment' => 'false',
        'auto_accept_underpayment_min' => '1.0',
        'auto_accept_overpayment' => 'false',
        'payer_user_agent' => null,
        'wallet_app_id' => null,
        'sid' => null,
        'require_kyt_for_confirmation' => 'false',
        'user' => 'user',
        'payer_kyc_pin' => '42355467',
    ];

    public function testItCallsStartPayment()
    {
        $fixtures = self::getFixturesJson('startPaymentResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'POST',
            Actions::START_PAYMENT,
            self::START_PAYMENT_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->startPayment(...array_values(self::START_PAYMENT_CALL_PARAMETERS));

        self::assertInstanceOf(StartPaymentResponse::class, $response);

        self::assertEquals('EUR', $response->getInvoiceCurrency());
        self::assertEquals('222.00', $response->getInvoiceAmount());
        self::assertEquals('BTC', $response->getCurrency());
        self::assertEquals('20822.2343', $response->getRate());
        self::assertEquals('0.01330448', $response->getAmountExchange());
        self::assertEquals('0.00002875', $response->getNetworkProcessingFee());
        self::assertEquals('0.01333323', $response->getAmount());
        self::assertEquals(1, $response->getMinConfirmations());
        self::assertEquals('Less than 2 minutes', $response->getWaitTime());
        self::assertEquals(null, $response->getSid());
        self::assertEquals('0.00012724', $response->getFastTransactionFee());
        self::assertEquals('BTC/kB', $response->getFastTransactionFeeCurrency());
        self::assertEquals(true, $response->isCancelled());
        self::assertEquals('btc-32d7e90b1ff241ab81a36e22696c0047', $response->getAddress());
        self::assertEquals('https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-32d7e90b1ff241ab81a36e22696c0047&amount=0.01333323', $response->getQr());
        self::assertEquals('https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-32d7e90b1ff241ab81a36e22696c0047', $response->getQrAlt());
        self::assertEquals('https://example-api.forumpay.com/qr/?d=https%3A%2F%2Fexample-pgw.forumpay.com%2FsandboxWallet.transfer%3Fcurrency%3DBTC%26address%3Dbtc-32d7e90b1ff241ab81a36e22696c0047%26amount%3D0.01333323', $response->getQrImg());
        self::assertEquals('https://example-api.forumpay.com/qr/?d=https%3A%2F%2Fexample-pgw.forumpay.com%2FsandboxWallet.transfer%3Fcurrency%3DBTC%26address%3Dbtc-32d7e90b1ff241ab81a36e22696c0047', $response->getQrAltImg());
        self::assertEquals('<SMALL>Solutions</SMALL><BR><SMALL>,</SMALL><BR><SMALL>Tax number:  </SMALL><BR><LINE><SMALL>Date:  2022-11-10 08: 43: 33</SMALL><BR>Reference:  web: 3547ade6-cab8-4ce8-9ec9-c4fd7286363c<BR><LINE><SMALL>FIAT amount: </SMALL><BR>222.00 EUR<BR><BR><BOLD>Total: </BOLD><BR><BOLD><BIG>0.01333323 BTC</BIG></BOLD><BR><QR>https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-32d7e90b1ff241ab81a36e22696c0047&amount=0.01333323</QR><BR><SMALL>Address: </SMALL><BR>https://example-pgw.forumpay.com/sandboxWallet.transfer?currency=BTC&address=btc-32d7e90b1ff241ab81a36e22696c0047<BR><BR><SMALL>TX fee set to: </SMALL><BR>0.00012724 BTC/kB<BR><BR><CUT><LINE><BR>', $response->getPrintString());
        self::assertEquals('fz7RCsx3Vl5VwijzFfVy1TssSiD8V9f2c7CAjKEKPzO7YvjfTHXFI5TT5lg22tDa', $response->getAccessToken());
        self::assertEquals('https://example-pgw.forumpay.com/pay?merchant_id=6a69b8ca-dc98-47d4-a33d-5edefee17f22&order_amount=222.00&order_currency=EUR&item_name=#checkPayment$web$3547ade6-cab8-4ce8-9ec9-c4fd7286363c$BTC$btc-32d7e90b1ff241ab81a36e22696c0047$6a69b8ca-dc98-47d4-a33d-5edefee17f22$fz7RCsx3Vl5VwijzFfVy1TssSiD8V9f2c7CAjKEKPzO7YvjfTHXFI5TT5lg22tDa$', $response->getAccessUrl());
        self::assertEquals('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXltZW50X2lkIjoiMzU0N2FkZTYtY2FiOC00Y2U4LTllYzktYzRmZDcyODYzNjNjIiwic3ViIjoifGV2ZW50cy5zdGF0c190b2tlbiIsImV4cCI6MTY3NTc5ODYwN30.BeYR3hjkHT30ZSu420db9NErIBwyGMOYVowqMjRHIl4', $response->getStatsToken());
        self::assertEquals([], $response->getNotices());
        self::assertEquals('3547ade6-cab8-4ce8-9ec9-c4fd7286363c', $response->getPaymentId());
    }

    public function testItFailsGracefullyOnInvalidStartPaymentResponse()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'POST',
            Actions::START_PAYMENT,
            self::START_PAYMENT_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->startPayment(...array_values(self::START_PAYMENT_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
