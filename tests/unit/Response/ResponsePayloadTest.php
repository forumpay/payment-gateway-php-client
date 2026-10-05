<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\unit\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayload;
use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayloadException;
use PHPUnit\Framework\TestCase;

class ResponsePayloadTest extends TestCase
{
    public function testItReadsRequiredAndOptionalFields()
    {
        $payload = ResponsePayload::fromArray([
            'name' => 'BTC',
            'note' => null,
            'count' => '2',
            'enabled' => '0',
        ]);

        self::assertSame('BTC', $payload->requiredString('name'));
        self::assertNull($payload->optionalString('note'));
        self::assertNull($payload->optionalString('missing'));
        self::assertSame(2, $payload->requiredInt('count'));
        self::assertFalse($payload->requiredBool('enabled'));
        self::assertTrue($payload->optionalBool('absent', true));
    }

    public function testRequiredStringRejectsMissingAndNull()
    {
        $payload = ResponsePayload::fromArray([
            'sid' => null,
        ]);

        try {
            $payload->requiredString('invoice_currency');
            self::fail('Missing required field should have failed');
        } catch (ResponsePayloadException $exception) {
            self::assertSame('Required field "$.invoice_currency" is missing from response', $exception->getMessage());
        }

        $this->expectException(ResponsePayloadException::class);
        $this->expectExceptionMessage('Required field "$.sid" cannot be null');
        $payload->requiredString('sid');
    }

    public function testItTracksNestedListPaths()
    {
        $payload = ResponsePayload::fromArray([
            'invoices' => [
                [
                    'state' => 'waiting',
                ],
                [
                    'status' => 'Waiting',
                ],
            ],
        ]);

        $invoices = $payload->requiredList('invoices');

        try {
            $invoices[1]->requiredString('state');
            self::fail('Missing nested field should have failed');
        } catch (ResponsePayloadException $exception) {
            self::assertSame('$.invoices[1].state', $exception->getFieldPath());
        }
    }

    public function testOptionalArrayAndListDefaultToEmptyWhenMissing()
    {
        $payload = ResponsePayload::fromArray([]);

        self::assertSame([], $payload->optionalArray('currencies', []));
        self::assertSame([], $payload->optionalList('invoices'));
    }

    public function testItRejectsANonArrayHttpResult()
    {
        $httpResult = new HttpResult('GET', 'https://example.test', [], '', null);

        $this->expectException(ResponsePayloadException::class);
        $this->expectExceptionMessage('Field "$" expected JSON object or array, got null');
        ResponsePayload::fromHttpResult($httpResult);
    }
}
