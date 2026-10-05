<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\RequestKycResponse;
use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayloadException;

class PaymentGatewayApiRequestKycIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const REQUEST_KYC_CALL_PARAMETERS = [
        'email' => 'email@mail.com',
    ];

    public function testItCallsRequestKyc()
    {
        $fixtures = self::getFixturesJson('requestKycResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'POST',
            Actions::REQUEST_KYC,
            self::REQUEST_KYC_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->requestKyc(...array_values(self::REQUEST_KYC_CALL_PARAMETERS));

        self::assertInstanceOf(RequestKycResponse::class, $response);

        self::assertEquals('ok', $response->getStatus());
    }

    public function testItFailsGracefullyOnInvalidRequestKycResponse()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'POST',
            Actions::REQUEST_KYC,
            self::REQUEST_KYC_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->requestKyc(...array_values(self::REQUEST_KYC_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(ResponsePayloadException::class, get_class($e->getPrevious()));
            self::assertEquals('$.status', $e->getPrevious()->getFieldPath());
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
