<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\GetWalletApps\WalletApp;
use ForumPay\PaymentGateway\PHPClient\Response\GetWalletAppsResponse;
use TypeError;

class PaymentGatewayApiGetWalletAppsIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_WALLET_APPS_CALL_PARAMETERS = [];

    public function testItCallsGetWalletApps()
    {
        $fixtures = self::getFixturesJson('getWalletAppsResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_WALLET_APPS,
            self::GET_WALLET_APPS_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getWalletApps();

        self::assertInstanceOf(GetWalletAppsResponse::class, $response);

        $walletApps = $response->getWalletApps();
        self::assertIsArray($walletApps);
        self::assertCount(2, $walletApps);

        /** @var WalletApp $walletApp1 */
        /** @var WalletApp $walletApp2 */
        [$walletApp1, $walletApp2] = $walletApps;

        self::assertInstanceOf(WalletApp::class, $walletApp1);
        self::assertEquals('27846ac7-9f56-4b28-a524-dc5d6fd29a01', $walletApp1->getId());
        self::assertEquals('Metamask', $walletApp1->getName());
        self::assertEquals('https://example-pgw.forumpay.com/pay/images/wallets/metamask.png', $walletApp1->getImage());
        self::assertEquals('https://example-pgw.forumpay.com/pay/images/wallets/metamask_white.png', $walletApp1->getImageDarkmode());

        self::assertInstanceOf(WalletApp::class, $walletApp2);
        self::assertEquals('f3a1b2c3-d4e5-6f7a-8b9c-0d1e2f3a4b5c', $walletApp2->getId());
        self::assertEquals('Trust Wallet', $walletApp2->getName());
        self::assertEquals('https://example-pgw.forumpay.com/pay/images/wallets/trustwallet.png', $walletApp2->getImage());
        self::assertEquals('https://example-pgw.forumpay.com/pay/images/wallets/trustwallet_white.png', $walletApp2->getImageDarkmode());
    }

    public function testItHandlesEmptyWalletAppsArray()
    {
        $this->setMockedApiResponse([]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_WALLET_APPS,
            self::GET_WALLET_APPS_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getWalletApps();

        self::assertInstanceOf(GetWalletAppsResponse::class, $response);
        self::assertIsArray($response->getWalletApps());
        self::assertCount(0, $response->getWalletApps());
    }

    public function testItReturnsCorrectArrayFromToArray()
    {
        $fixtures = self::getFixturesJson('getWalletAppsResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_WALLET_APPS,
            self::GET_WALLET_APPS_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getWalletApps();

        $array = $response->toArray();

        self::assertIsArray($array);
        self::assertArrayHasKey('wallet_apps', $array);
        self::assertIsArray($array['wallet_apps']);
        self::assertCount(2, $array['wallet_apps']);

        self::assertEquals('27846ac7-9f56-4b28-a524-dc5d6fd29a01', $array['wallet_apps'][0]['id']);
        self::assertEquals('Metamask', $array['wallet_apps'][0]['name']);
    }

    public function testItFailsGracefullyOnInvalidGetWalletAppsResponse()
    {
        $this->setMockedApiResponse([[
            'id' => 123,
            'name' => 456,
            'image' => null,
            'image_darkmode' => null,
        ]]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_WALLET_APPS,
            self::GET_WALLET_APPS_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getWalletApps();
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
