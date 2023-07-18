<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetCurrencyList;

class Currency
{
    private string $currency;

    private string $description;

    private string $status;

    private int $zeroConfirmationsEnabled;

    private string $currencyFiat;

    private ?string $rate;

    private string $sellStatus;

    private ?string $sellRate;

    private string $buyStatus;

    private ?string $buyRate;

    private ?string $sellMinInvoiceAmount;

    private ?string $sellMaxInvoiceAmount;

    private ?string $sellNetworkProcessingFee;

    private ?string $buyMinInvoiceAmount;

    private ?string $buyMaxInvoiceAmount;

    private ?string $buyNetworkProcessingFee;

    public function __construct(
        string $currency,
        string $description,
        string $status,
        int $zeroConfirmationsEnabled,
        string $currencyFiat,
        ?string $rate,
        string $sellStatus,
        ?string $sellRate,
        string $buyStatus,
        ?string $buyRate,
        ?string $sellMinInvoiceAmount,
        ?string $sellMaxInvoiceAmount,
        ?string $sellNetworkProcessingFee,
        ?string $buyMinInvoiceAmount,
        ?string $buyMaxInvoiceAmount,
        ?string $buyNetworkProcessingFee
    ) {
        $this->currency = $currency;
        $this->description = $description;
        $this->status = $status;
        $this->zeroConfirmationsEnabled = $zeroConfirmationsEnabled;
        $this->currencyFiat = $currencyFiat;
        $this->rate = $rate;
        $this->sellStatus = $sellStatus;
        $this->sellRate = $sellRate;
        $this->buyStatus = $buyStatus;
        $this->buyRate = $buyRate;
        $this->sellMinInvoiceAmount = $sellMinInvoiceAmount;
        $this->sellMaxInvoiceAmount = $sellMaxInvoiceAmount;
        $this->sellNetworkProcessingFee = $sellNetworkProcessingFee;
        $this->buyMinInvoiceAmount = $buyMinInvoiceAmount;
        $this->buyMaxInvoiceAmount = $buyMaxInvoiceAmount;
        $this->buyNetworkProcessingFee = $buyNetworkProcessingFee;
    }

    public static function createFromArray(array $currency): self
    {
        return new self(
            $currency['currency'],
            $currency['description'],
            $currency['status'],
            (int) $currency['zero_confirmations_enabled'],
            $currency['currency_fiat'],
            $currency['rate'],
            $currency['sell_status'],
            $currency['sell_rate'],
            $currency['buy_status'],
            $currency['buy_rate'],
            $currency['sell_min_invoice_amount'],
            $currency['sell_max_invoice_amount'],
            $currency['sell_network_processing_fee'],
            $currency['buy_min_invoice_amount'],
            $currency['buy_max_invoice_amount'],
            $currency['buy_network_processing_fee'],
        );
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getZeroConfirmationsEnabled(): int
    {
        return $this->zeroConfirmationsEnabled;
    }

    public function getCurrencyFiat(): string
    {
        return $this->currencyFiat;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function getSellStatus(): string
    {
        return $this->sellStatus;
    }

    public function getSellRate(): ?string
    {
        return $this->sellRate;
    }

    public function getBuyStatus(): string
    {
        return $this->buyStatus;
    }

    public function getBuyRate(): ?string
    {
        return $this->buyRate;
    }

    public function getSellMinInvoiceAmount(): ?string
    {
        return $this->sellMinInvoiceAmount;
    }

    public function getSellMaxInvoiceAmount(): ?string
    {
        return $this->sellMaxInvoiceAmount;
    }

    public function getSellNetworkProcessingFee(): ?string
    {
        return $this->sellNetworkProcessingFee;
    }

    public function getBuyMinInvoiceAmount(): ?string
    {
        return $this->buyMinInvoiceAmount;
    }

    public function getBuyMaxInvoiceAmount(): ?string
    {
        return $this->buyMaxInvoiceAmount;
    }

    public function getBuyNetworkProcessingFee(): ?string
    {
        return $this->buyNetworkProcessingFee;
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'description' => $this->description,
            'status' => $this->status,
            'zero_confirmations_enabled' => $this->zeroConfirmationsEnabled,
            'currency_fiat' => $this->currencyFiat,
            'rate' => $this->rate,
            'sell_status' => $this->sellStatus,
            'sell_rate' => $this->sellRate,
            'buy_status' => $this->buyStatus,
            'buy_rate' => $this->buyRate,
            'sell_min_invoice_amount' => $this->sellMinInvoiceAmount,
            'sell_max_invoice_amount' => $this->sellMaxInvoiceAmount,
            'sell_network_processing_fee' => $this->sellNetworkProcessingFee,
            'buy_min_invoice_amount' => $this->buyMinInvoiceAmount,
            'buy_max_invoice_amount' => $this->buyMaxInvoiceAmount,
            'buy_network_processing_fee' => $this->buyNetworkProcessingFee,
        ];
    }
}
