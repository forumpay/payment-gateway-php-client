<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\MeResponse;
use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayloadException;

class PaymentGatewayApiGetMeIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_ME_CALL_PARAMETERS = [];

    public function testItCallsGetMe(): void
    {
        $fixtures = self::getFixturesJson('meResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::ME,
            self::GET_ME_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getMe();

        self::assertInstanceOf(MeResponse::class, $response);
        self::assertSame(['can_sell', 'can_buy', 'can_refund'], $response->getApiPermissions());
        self::assertSame('8b6231f0-d9ff-4ee3-acd5-ccd6a25ead44', $response->getAccountId());
        self::assertSame($fixtures, $response->toArray());
    }

    public function testItFailsWhenPermissionsAreAbsent(): void
    {
        $this->setMockedApiResponse([
            'api' => [],
            'account' => [
                'id' => '8b6231f0-d9ff-4ee3-acd5-ccd6a25ead44',
            ],
        ]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::ME,
            self::GET_ME_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getMe();
        } catch (InvalidResponseException $e) {
            self::assertEquals(ResponsePayloadException::class, get_class($e->getPrevious()));
            self::assertEquals('$.api.permissions', $e->getPrevious()->getFieldPath());
            return;
        }

        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }

    public function testItFailsGracefullyOnInvalidMeResponse(): void
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::ME,
            self::GET_ME_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getMe();
        } catch (InvalidResponseException $e) {
            self::assertEquals(ResponsePayloadException::class, get_class($e->getPrevious()));
            self::assertEquals('$.api', $e->getPrevious()->getFieldPath());
            return;
        }

        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
