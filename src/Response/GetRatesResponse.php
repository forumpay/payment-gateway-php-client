<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class GetRatesResponse
{
    private string $paymentId;

    private string $invoiceAmount;

    private string $invoiceCurrency;

    private ?string $sid;

    private array $currencies;

    public function __construct(
        string $paymentId,
        string $invoiceAmount,
        string $invoiceCurrency,
        ?string $sid,
        array $currencies
    ) {
        $this->paymentId = $paymentId;
        $this->invoiceAmount = $invoiceAmount;
        $this->invoiceCurrency = $invoiceCurrency;
        $this->sid = $sid;
        $this->currencies = $currencies;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        return new self(
            $responseJson['payment_id'],
            $responseJson['invoice_amount'],
            $responseJson['invoice_currency'],
            $responseJson['sid'] ?? null,
            $responseJson['currencies'] ?? []
        );
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getInvoiceAmount(): string
    {
        return $this->invoiceAmount;
    }

    public function getInvoiceCurrency(): string
    {
        return $this->invoiceCurrency;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'invoice_amount' => $this->invoiceAmount,
            'invoice_currency' => $this->invoiceCurrency,
            'sid' => $this->sid,
            'currencies' => $this->currencies,
        ];
    }
}
