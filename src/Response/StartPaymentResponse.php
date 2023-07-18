<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;

class StartPaymentResponse
{
    private string $invoiceCurrency;

    private ?string $invoiceAmount;

    private string $currency;

    private ?string $rate;

    private ?string $amountExchange;

    private string $networkProcessingFee;

    private ?string $amount;

    private int $minConfirmations;

    private string $waitTime;

    private ?string $sid;

    private ?string $fastTransactionFee;

    private ?string $fastTransactionFeeCurrency;

    private bool $cancelled;

    private string $address;

    private string $qr;

    private string $qrAlt;

    private string $qrImg;

    private string $qrAltImg;

    private ?string $printString;

    private string $accessToken;

    private string $accessUrl;

    private string $statsToken;

    private array $notices;

    private string $paymentId;

    public function __construct(
        string $invoiceCurrency,
        ?string $invoiceAmount,
        string $currency,
        ?string $rate,
        ?string $amountExchange,
        string $networkProcessingFee,
        ?string $amount,
        int $minConfirmations,
        string $waitTime,
        ?string $sid,
        ?string $fastTransactionFee,
        ?string $fastTransactionFeeCurrency,
        bool $cancelled,
        string $address,
        string $qr,
        string $qrAlt,
        string $qrImg,
        string $qrAltImg,
        ?string $printString,
        string $accessToken,
        string $accessUrl,
        string $statsToken,
        array $notices,
        string $paymentId
    ) {
        $this->invoiceCurrency = $invoiceCurrency;
        $this->invoiceAmount = $invoiceAmount;
        $this->currency = $currency;
        $this->rate = $rate;
        $this->amountExchange = $amountExchange;
        $this->networkProcessingFee = $networkProcessingFee;
        $this->amount = $amount;
        $this->minConfirmations = $minConfirmations;
        $this->waitTime = $waitTime;
        $this->sid = $sid;
        $this->fastTransactionFee = $fastTransactionFee;
        $this->fastTransactionFeeCurrency = $fastTransactionFeeCurrency;
        $this->cancelled = $cancelled;
        $this->address = $address;
        $this->qr = $qr;
        $this->qrAlt = $qrAlt;
        $this->qrImg = $qrImg;
        $this->qrAltImg = $qrAltImg;
        $this->printString = $printString;
        $this->accessToken = $accessToken;
        $this->accessUrl = $accessUrl;
        $this->statsToken = $statsToken;
        $this->notices = $notices;
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
            (int) $responseJson['min_confirmations'],
            $responseJson['wait_time'],
            $responseJson['sid'],
            $responseJson['fast_transaction_fee'],
            $responseJson['fast_transaction_fee_currency'],
            $responseJson['cancelled'] ?? false,
            $responseJson['address'],
            $responseJson['qr'],
            $responseJson['qr_alt'],
            $responseJson['qr_img'],
            $responseJson['qr_alt_img'],
            $responseJson['print_string'],
            $responseJson['access_token'],
            $responseJson['access_url'],
            $responseJson['stats_token'],
            $responseJson['notices'],
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

    public function getMinConfirmations(): int
    {
        return $this->minConfirmations;
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

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getQr(): string
    {
        return $this->qr;
    }

    public function getQrAlt(): string
    {
        return $this->qrAlt;
    }

    public function getQrImg(): string
    {
        return $this->qrImg;
    }

    public function getQrAltImg(): string
    {
        return $this->qrAltImg;
    }

    public function getPrintString(): ?string
    {
        return $this->printString;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getAccessUrl(): string
    {
        return $this->accessUrl;
    }

    public function getStatsToken(): string
    {
        return $this->statsToken;
    }

    public function getNotices(): array
    {
        return $this->notices;
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
            'min_confirmations' => $this->minConfirmations,
            'wait_time' => $this->waitTime,
            'sid' => $this->sid,
            'fast_transaction_fee' => $this->fastTransactionFee,
            'fast_transaction_fee_currency' => $this->fastTransactionFeeCurrency,
            'cancelled' => $this->cancelled,
            'address' => $this->address,
            'qr' => $this->qr,
            'qr_alt' => $this->qrAlt,
            'qr_img' => $this->qrImg,
            'qr_alt_img' => $this->qrAltImg,
            'print_string' => $this->printString,
            'access_token' => $this->accessToken,
            'access_url' => $this->accessUrl,
            'stats_token' => $this->statsToken,
            'notices' => $this->notices,
            'payment_id' => $this->paymentId,
        ];
    }
}
