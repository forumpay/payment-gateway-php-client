<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Test\integration\PaymentGatewayApi;

use ForumPay\PaymentGateway\PHPClient\Http\Exception\InvalidResponseException;
use ForumPay\PaymentGateway\PHPClient\Map\Actions;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\TransactionInvoice;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactionsResponse;
use TypeError;

class PaymentGatewayApiGetTransactionsIntegrationTest extends AbstractPaymentGatewayApiIntegrationTest
{
    private const GET_TRANSACTIONS_CALL_PARAMETERS = [
        'offset' => 0,
        'limit' => 2,
        'reference_no' => 'some invoice_no_2 value',
    ];

    public function testItCallsGetTransactions()
    {
        $fixtures = self::getFixturesJson('getTransactionsResponse');
        $this->setMockedApiResponse($fixtures);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_TRANSACTIONS,
            self::GET_TRANSACTIONS_CALL_PARAMETERS
        );

        $response = $paymentGatewayApi->getTransactions(...array_values(self::GET_TRANSACTIONS_CALL_PARAMETERS));

        self::assertInstanceOf(GetTransactionsResponse::class, $response);

        [$invoice1, $invoice2] = $response->getInvoices();

        self::assertInstanceOf(TransactionInvoice::class, $invoice1);

        self::assertEquals('waiting', $invoice1->getState());
        self::assertEquals('Waiting', $invoice1->getStatus());
        self::assertEquals('Waiting', $invoice1->getStatusLoc());
        self::assertEquals('web', $invoice1->getPosId());
        self::assertEquals('EUR', $invoice1->getInvoiceCurrency());
        self::assertEquals('222.00', $invoice1->getInvoiceAmount());
        self::assertEquals('BTC', $invoice1->getCurrency());
        self::assertEquals('0.01069040', $invoice1->getAmount());
        self::assertEquals('0.01066165', $invoice1->getAmountExchange());
        self::assertEquals('0.00002875', $invoice1->getNetworkProcessingFee());
        self::assertEquals('btc-793772d7f5a4463ea9737bb2d5c35204', $invoice1->getAddress());
        self::assertEquals('Sell', $invoice1->getType());
        self::assertEquals('Sell', $invoice1->getTypeLoc());
        self::assertEquals(null, $invoice1->getPayment());
        self::assertEquals('', $invoice1->getRefund());
        self::assertEquals('', $invoice1->getRefundAmountOpened());
        self::assertEquals(null, $invoice1->getRefundStatus());
        self::assertEquals(null, $invoice1->getRefundStatusLoc());
        self::assertEquals(null, $invoice1->getInvoiceDate());
        self::assertEquals('2023-02-08 15:15:07', $invoice1->getInserted());
        self::assertEquals(null, $invoice1->getConfirmed());
        self::assertEquals(null, $invoice1->getCancelled());
        self::assertEquals(null, $invoice1->getDoubleSpendingAlert());
        self::assertEquals(false, $invoice1->isAcceptZeroConfirmations());
        self::assertEquals(null, $invoice1->getItemName());
        self::assertEquals('HV0Lzn2I5gZ0_q6lssWgfErJAUS9vum5TzgD1qlNs32NThmnE5Uh4QEzTghmHTp_', $invoice1->getAccessToken());
        self::assertEquals(null, $invoice1->getSid());
        self::assertEquals('8b6231f0-d9ff-4ee3-acd5-ccd6a25ead44', $invoice1->getPaymentId());

        self::assertInstanceOf(TransactionInvoice::class, $invoice2);

        self::assertEquals('waiting', $invoice2->getState());
        self::assertEquals('Waiting', $invoice2->getStatus());
        self::assertEquals('Waiting', $invoice2->getStatusLoc());
        self::assertEquals('web', $invoice2->getPosId());
        self::assertEquals('EUR', $invoice2->getInvoiceCurrency());
        self::assertEquals('222.00', $invoice2->getInvoiceAmount());
        self::assertEquals('BTC', $invoice2->getCurrency());
        self::assertEquals('0.01069040', $invoice2->getAmount());
        self::assertEquals('0.01066165', $invoice2->getAmountExchange());
        self::assertEquals('0.00002875', $invoice2->getNetworkProcessingFee());
        self::assertEquals('btc-10468a3d844846edb027b6f2c096c6e3', $invoice2->getAddress());
        self::assertEquals('Sell', $invoice2->getType());
        self::assertEquals('Sell', $invoice2->getTypeLoc());
        self::assertEquals(null, $invoice2->getPayment());
        self::assertEquals('', $invoice2->getRefund());
        self::assertEquals('', $invoice2->getRefundAmountOpened());
        self::assertEquals(null, $invoice2->getRefundStatus());
        self::assertEquals(null, $invoice2->getRefundStatusLoc());
        self::assertEquals(null, $invoice2->getInvoiceDate());
        self::assertEquals('2023-02-08 15:13:45', $invoice2->getInserted());
        self::assertEquals(null, $invoice2->getConfirmed());
        self::assertEquals(null, $invoice2->getCancelled());
        self::assertEquals(null, $invoice2->getDoubleSpendingAlert());
        self::assertEquals(false, $invoice2->isAcceptZeroConfirmations());
        self::assertEquals(null, $invoice2->getItemName());
        self::assertEquals('VfanF1RFzAmIywMOuYrfNn9aQqwNzkwPcnzmePH542LxZOvRqAOmTOBTKxulU16P', $invoice2->getAccessToken());
        self::assertEquals(null, $invoice2->getSid());
        self::assertEquals('810a90b2-e780-4396-8bb7-36b01c492021', $invoice2->getPaymentId());
    }

    public function testItFailsGracefullyOnInvalidGetTransactionsResponse()
    {
        $this->setMockedApiResponse([
            'invoices' => [
                'state' => 0,
            ],
        ]);

        $paymentGatewayApi = self::getPaymentGatewayApiWithHttpClientMock(
            'GET',
            Actions::GET_TRANSACTIONS,
            self::GET_TRANSACTIONS_CALL_PARAMETERS
        );

        try {
            $paymentGatewayApi->getTransactions(...array_values(self::GET_TRANSACTIONS_CALL_PARAMETERS));
        } catch (InvalidResponseException $e) {
            self::assertEquals(TypeError::class, get_class($e->getPrevious()));
            return;
        }
        self::fail(sprintf('Should\'ve failed with %s exception', InvalidResponseException::class));
    }
}
