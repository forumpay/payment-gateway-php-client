<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\TransactionInvoice;
use RuntimeException;

class GetTransactionsResponse
{
    private array $invoices;

    public function __construct(
        array $invoices
    ) {
        $this->invoices = $invoices;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        if (self::isResponseValid($httpResult->getResponse())) {
            return new self(
                array_map(
                    fn (array $invoice) => TransactionInvoice::createFromArray($invoice),
                    $httpResult->getResponse()['invoices'] ?? []
                )
            );
        } else {
            throw new RuntimeException(sprintf('Invalid GetTransactions response: "%s"', json_encode($httpResult->getResponse(), JSON_THROW_ON_ERROR)));
        }
    }

    private static function isResponseValid(?array $response): bool
    {
        return $response === null || isset($response['invoices']);
    }

    public function getInvoices(): array
    {
        return $this->invoices;
    }

    public function toArray(): array
    {
        return [
            'invoices' => array_map(
                fn (TransactionInvoice $invoice) => $invoice->toArray(),
                $this->invoices
            ),
        ];
    }
}
