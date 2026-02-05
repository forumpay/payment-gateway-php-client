<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\CheckPayment\Underpayment;

class CheckPaymentResponse
{
    private ?string $referenceNo;

    private string $inserted;

    private ?string $invoiceAmount;

    private string $type;

    private string $invoiceCurrency;

    private ?string $amount;

    private ?string $originalAmount;

    private int $minConfirmations;

    private bool $acceptZeroConfirmations;

    private bool $requireKytForConfirmation;

    private string $currency;

    private bool $confirmed;

    private ?string $confirmedTime;

    private ?string $reason;

    private ?string $payment;

    private ?string $sid;

    private string $confirmations;

    private ?string $accessToken;

    private ?string $accessUrl;

    private ?string $waitTime;

    private string $status;

    private ?string $unconfirmedAmount;

    private ?string $unconfirmedInvoiceAmount;

    private ?Underpayment $underpayment;

    private bool $cancelled;

    private ?string $cancelledTime;

    private ?string $printString;

    private string $state;

    private ?string $itemName;

    private ?string $invoiceSurchargeAmount;

    private ?string $invoiceAmountWithSurcharge;

    private ?string $invoiceSurchargePercent;

    public function __construct(
        ?string $referenceNo,
        string $inserted,
        ?string $invoiceAmount,
        string $type,
        string $invoiceCurrency,
        ?string $amount,
        ?string $originalAmount,
        int $minConfirmations,
        bool $acceptZeroConfirmations,
        bool $requireKytForConfirmation,
        string $currency,
        bool $confirmed,
        ?string $confirmedTime,
        ?string $reason,
        ?string $payment,
        ?string $sid,
        string $confirmations,
        ?string $accessToken,
        ?string $accessUrl,
        ?string $waitTime,
        string $status,
        ?string $unconfirmedAmount,
        ?string $unconfirmedInvoiceAmount,
        ?Underpayment $underpayment,
        bool $cancelled,
        ?string $cancelledTime,
        ?string $printString,
        string $state,
        ?string $itemName,
        ?string $invoiceSurchargeAmount,
        ?string $invoiceAmountWithSurcharge,
        ?string $invoiceSurchargePercent
    ) {
        $this->referenceNo = $referenceNo;
        $this->inserted = $inserted;
        $this->invoiceAmount = $invoiceAmount;
        $this->type = $type;
        $this->invoiceCurrency = $invoiceCurrency;
        $this->amount = $amount;
        $this->originalAmount = $originalAmount;
        $this->minConfirmations = $minConfirmations;
        $this->acceptZeroConfirmations = $acceptZeroConfirmations;
        $this->requireKytForConfirmation = $requireKytForConfirmation;
        $this->currency = $currency;
        $this->confirmed = $confirmed;
        $this->confirmedTime = $confirmedTime;
        $this->reason = $reason;
        $this->payment = $payment;
        $this->sid = $sid;
        $this->confirmations = $confirmations;
        $this->accessToken = $accessToken;
        $this->accessUrl = $accessUrl;
        $this->waitTime = $waitTime;
        $this->status = $status;
        $this->unconfirmedAmount = $unconfirmedAmount;
        $this->unconfirmedInvoiceAmount = $unconfirmedInvoiceAmount;
        $this->underpayment = $underpayment;
        $this->cancelled = $cancelled;
        $this->cancelledTime = $cancelledTime;
        $this->printString = $printString;
        $this->state = $state;
        $this->itemName = $itemName;
        $this->invoiceSurchargeAmount = $invoiceSurchargeAmount;
        $this->invoiceAmountWithSurcharge = $invoiceAmountWithSurcharge;
        $this->invoiceSurchargePercent = $invoiceSurchargePercent;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        $responseJson = $httpResult->getResponse();

        return new self(
            $responseJson['reference_no'],
            $responseJson['inserted'],
            $responseJson['invoice_amount'],
            $responseJson['type'],
            $responseJson['invoice_currency'],
            $responseJson['amount'],
            $responseJson['original_amount'] ?? null,
            (int) $responseJson['min_confirmations'],
            (bool) $responseJson['accept_zero_confirmations'],
            (bool) $responseJson['require_kyt_for_confirmation'],
            $responseJson['currency'],
            $responseJson['confirmed'],
            $responseJson['confirmed_time'],
            $responseJson['reason'],
            $responseJson['payment'],
            $responseJson['sid'],
            $responseJson['confirmations'],
            $responseJson['access_token'],
            $responseJson['access_url'],
            $responseJson['wait_time'],
            $responseJson['status'],
            $responseJson['unconfirmed_amount'] ?? null,
            $responseJson['unconfirmed_invoice_amount'] ?? null,
            isset($responseJson['underpayment']) ? Underpayment::createFromArray($responseJson['underpayment']) : null,
            $responseJson['cancelled'] ?? false,
            $responseJson['cancelled_time'] ?? null,
            $responseJson['print_string'],
            $responseJson['state'],
            $responseJson['item_name'] ?? null,
            $responseJson['invoice_surcharge_amount'] ?? null,
            $responseJson['invoice_amount_with_surcharge'] ?? null,
            $responseJson['invoice_surcharge_percent'] ?? null
        );
    }

    public function getReferenceNo(): ?string
    {
        return $this->referenceNo;
    }

    public function getInserted(): string
    {
        return $this->inserted;
    }

    public function getInvoiceAmount(): ?string
    {
        return $this->invoiceAmount;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getInvoiceCurrency(): string
    {
        return $this->invoiceCurrency;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getOriginalAmount(): ?string
    {
        return $this->originalAmount;
    }

    public function getMinConfirmations(): int
    {
        return $this->minConfirmations;
    }

    public function isAcceptZeroConfirmations(): bool
    {
        return $this->acceptZeroConfirmations;
    }

    public function isRequireKytForConfirmation(): bool
    {
        return $this->requireKytForConfirmation;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function getConfirmedTime(): ?string
    {
        return $this->confirmedTime;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function getConfirmations(): string
    {
        return $this->confirmations;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getAccessUrl(): ?string
    {
        return $this->accessUrl;
    }

    public function getWaitTime(): ?string
    {
        return $this->waitTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUnconfirmedAmount(): ?string
    {
        return $this->unconfirmedAmount;
    }

    public function getUnconfirmedInvoiceAmount(): ?string
    {
        return $this->unconfirmedInvoiceAmount;
    }

    public function getUnderpayment(): ?Underpayment
    {
        return $this->underpayment;
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function getCancelledTime(): ?string
    {
        return $this->cancelledTime;
    }

    public function getPrintString(): ?string
    {
        return $this->printString;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function getInvoiceSurchargeAmount(): ?string
    {
        return $this->invoiceSurchargeAmount;
    }

    public function getInvoiceAmountWithSurcharge(): ?string
    {
        return $this->invoiceAmountWithSurcharge;
    }

    public function getInvoiceSurchargePercent(): ?string
    {
        return $this->invoiceSurchargePercent;
    }

    public function toArray(): array
    {
        return [
            'reference_no' => $this->referenceNo,
            'inserted' => $this->inserted,
            'invoice_amount' => $this->invoiceAmount,
            'type' => $this->type,
            'invoice_currency' => $this->invoiceCurrency,
            'amount' => $this->amount,
            'original_amount' => $this->originalAmount,
            'min_confirmations' => $this->minConfirmations,
            'accept_zero_confirmations' => $this->acceptZeroConfirmations,
            'require_kyt_for_confirmation' => $this->requireKytForConfirmation,
            'currency' => $this->currency,
            'confirmed' => $this->confirmed,
            'confirmed_time' => $this->confirmedTime,
            'reason' => $this->reason,
            'payment' => $this->payment,
            'sid' => $this->sid,
            'confirmations' => $this->confirmations,
            'access_token' => $this->accessToken,
            'access_url' => $this->accessUrl,
            'wait_time' => $this->waitTime,
            'status' => $this->status,
            'unconfirmed_amount' => $this->unconfirmedAmount,
            'unconfirmed_invoice_amount' => $this->unconfirmedInvoiceAmount,
            'underpayment' => $this->underpayment !== null ? $this->underpayment->toArray() : null,
            'cancelled' => $this->cancelled,
            'cancelled_time' => $this->cancelledTime,
            'print_string' => $this->printString,
            'state' => $this->state,
            'item_name' => $this->itemName,
            'invoice_surcharge_amount' => $this->invoiceSurchargeAmount,
            'invoice_amount_with_surcharge' => $this->invoiceAmountWithSurcharge,
            'invoice_surcharge_percent' => $this->invoiceSurchargePercent,
        ];
    }
}
