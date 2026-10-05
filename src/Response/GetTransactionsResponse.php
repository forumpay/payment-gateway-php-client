<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\TransactionInvoice;

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
        // Gateway returns null when no payments were found (backwards compatibility).
        if ($httpResult->getResponse() === null) {
            return new self([]);
        }

        $payload = ResponsePayload::fromHttpResult($httpResult);

        return new self(
            array_map(
                static function (ResponsePayload $invoice): TransactionInvoice {
                    return TransactionInvoice::createFromArray($invoice->getData(), $invoice->getPath());
                },
                $payload->optionalList('invoices')
            )
        );
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
