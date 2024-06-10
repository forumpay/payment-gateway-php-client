<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Api\UriParser;
use ForumPay\PaymentGateway\PHPClient\Http\HttpClient;
use ForumPay\PaymentGateway\PHPClient\Http\HttpClientInterface;
use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\PaymentGatewayApi;
use ForumPay\PaymentGateway\PHPClient\PaymentGatewayApiInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractPaymentGatewayApiIntegrationTest extends TestCase
{
    private const MOCK_PGW_URI = 'https://example-pgw-uri.com';

    private const MOCK_USER = 'user';

    private const MOCK_PASSWORD = 'password';

    private const MOCK_USER_AGENT = 'user-agent';

    private const MOCK_LOCALE = 'en-GB';

    private array $mockedApiResponse;

    protected static function getFixturesJson(string $fixturesName): array
    {
        $filepath = sprintf('./tests/integration/PaymentGatewayApi/fixtures/%s.json', $fixturesName);
        $fileContent = file_get_contents($filepath);

        return json_decode($fileContent, true);
    }

    protected function getPaymentGatewayApiWithHttpClientMock(string $method, string $action, array $callParameters): PaymentGatewayApiInterface
    {
        return new PaymentGatewayApi(
            self::MOCK_PGW_URI,
            self::MOCK_USER,
            self::MOCK_PASSWORD,
            self::MOCK_USER_AGENT,
            self::MOCK_LOCALE,
            $this->getHttpClientMock($method, $action, $callParameters),
        );
    }

    private function getHttpClientMock(string $method, string $action, array $callParameters): HttpClientInterface
    {
        $callParameters += [
            'locale' => self::MOCK_LOCALE,
        ];

        $cfRayId = "Cloudflare RayId";

        $apiCallerMock = $this->getMockBuilder(HttpClient::class)
            ->setConstructorArgs([self::MOCK_USER_AGENT])
            ->onlyMethods(['call'])
            ->getMock();

        $uri = UriParser::getUri(self::MOCK_PGW_URI, $action);

        $httpResult = new HttpResult($method, $uri, $callParameters, $cfRayId, $this->mockedApiResponse, [], '');
        $apiCallerMock
            ->method('call')
            ->with(
                $method,
                $uri,
                self::MOCK_USER,
                self::MOCK_PASSWORD,
                $callParameters
            )
            ->willReturn($httpResult);

        return $apiCallerMock;
    }

    public function setMockedApiResponse(array $mockedApiResponse): void
    {
        $this->mockedApiResponse = $mockedApiResponse;
    }

    protected function getResponseString(): string
    {
        return json_encode($this->mockedApiResponse);
    }
}
