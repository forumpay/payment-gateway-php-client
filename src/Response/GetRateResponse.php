<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class GetRateResponse
{
    private string $invoiceCurrency;

    private ?string $invoiceAmount;

    private string $currency;

    private ?string $rate;

    private ?string $amountExchange;

    private string $networkProcessingFee;

    private ?string $amount;

    private string $waitTime;

    private ?string $sid;

    private ?string $fastTransactionFee;

    private ?string $fastTransactionFeeCurrency;

    private string $paymentId;

    public function __construct(
        string $invoiceCurrency,
        ?string $invoiceAmount,
        string $currency,
        ?string $rate,
        ?string $amountExchange,
        string $networkProcessingFee,
        ?string $amount,
        string $waitTime,
        ?string $sid,
        ?string $fastTransactionFee,
        ?string $fastTransactionFeeCurrency,
        string $paymentId
    ) {
        $this->invoiceCurrency = $invoiceCurrency;
        $this->invoiceAmount = $invoiceAmount;
        $this->currency = $currency;
        $this->rate = $rate;
        $this->amountExchange = $amountExchange;
        $this->networkProcessingFee = $networkProcessingFee;
        $this->amount = $amount;
        $this->waitTime = $waitTime;
        $this->sid = $sid;
        $this->fastTransactionFee = $fastTransactionFee;
        $this->fastTransactionFeeCurrency = $fastTransactionFeeCurrency;
        $this->paymentId = $paymentId;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        return new self(
            $responseJson['invoice_currency'],
            $responseJson['invoice_amount'],
            $responseJson['currency'],
            $responseJson['rate'],
            $responseJson['amount_exchange'],
            $responseJson['network_processing_fee'],
            $responseJson['amount'],
            $responseJson['wait_time'],
            $responseJson['sid'],
            $responseJson['fast_transaction_fee'],
            $responseJson['fast_transaction_fee_currency'],
            $responseJson['payment_id']
        );
    }

    public function getInvoiceCurrency(): string
    {
        return $this->invoiceCurrency;
    }

    public function getInvoiceAmount(): ?string
    {
        return $this->invoiceAmount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function getAmountExchange(): ?string
    {
        return $this->amountExchange;
    }

    public function getNetworkProcessingFee(): string
    {
        return $this->networkProcessingFee;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getWaitTime(): string
    {
        return $this->waitTime;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function getFastTransactionFee(): ?string
    {
        return $this->fastTransactionFee;
    }

    public function getFastTransactionFeeCurrency(): ?string
    {
        return $this->fastTransactionFeeCurrency;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function toArray(): array
    {
        return [
            'invoice_currency' => $this->invoiceCurrency,
            'invoice_amount' => $this->invoiceAmount,
            'currency' => $this->currency,
            'rate' => $this->rate,
            'amount_exchange' => $this->amountExchange,
            'network_processing_fee' => $this->networkProcessingFee,
            'amount' => $this->amount,
            'wait_time' => $this->waitTime,
            'sid' => $this->sid,
            'fast_transaction_fee' => $this->fastTransactionFee,
            'fast_transaction_fee_currency' => $this->fastTransactionFeeCurrency,
            'payment_id' => $this->paymentId,
        ];
    }
}
