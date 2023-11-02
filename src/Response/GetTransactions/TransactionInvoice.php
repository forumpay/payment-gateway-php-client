<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetTransactions;

use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\CustomerDetails;

class TransactionInvoice
{
    private string $state;

    private string $status;

    private string $statusLoc;

    private string $posId;

    private string $invoiceCurrency;

    private ?string $invoiceAmount;

    private string $currency;

    private ?string $amount;

    private ?string $amountExchange;

    private string $networkProcessingFee;

    private string $address;

    private string $type;

    private string $typeLoc;

    private ?string $payment;

    private ?string $refund;

    private ?string $refundAmountOpened;

    private ?string $refundStatus;

    private ?string $refundStatusLoc;

    private ?string $invoiceDate;

    private string $inserted;

    private ?string $confirmed;

    private ?string $cancelled;

    private ?string $doubleSpendingAlert;

    private bool $acceptZeroConfirmations;

    private ?string $itemName;

    private ?string $accessToken;

    private ?string $sid;

    private ?string $paymentId;

    private ?CustomerDetails $customerDetails;

    public function __construct(
        string $state,
        string $status,
        string $statusLoc,
        string $posId,
        string $invoiceCurrency,
        ?string $invoiceAmount,
        string $currency,
        ?string $amount,
        ?string $amountExchange,
        string $networkProcessingFee,
        string $address,
        string $type,
        string $typeLoc,
        ?string $payment,
        ?string $refund,
        ?string $refundAmountOpened,
        ?string $refundStatus,
        ?string $refundStatusLoc,
        ?string $invoiceDate,
        string $inserted,
        ?string $confirmed,
        ?string $cancelled,
        ?string $doubleSpendingAlert,
        bool $acceptZeroConfirmations,
        ?string $itemName,
        ?string $accessToken,
        ?string $sid,
        ?string $paymentId,
        ?CustomerDetails $customerDetails
    ) {
        $this->state = $state;
        $this->status = $status;
        $this->statusLoc = $statusLoc;
        $this->posId = $posId;
        $this->invoiceCurrency = $invoiceCurrency;
        $this->invoiceAmount = $invoiceAmount;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->amountExchange = $amountExchange;
        $this->networkProcessingFee = $networkProcessingFee;
        $this->address = $address;
        $this->type = $type;
        $this->typeLoc = $typeLoc;
        $this->payment = $payment;
        $this->refund = $refund;
        $this->refundAmountOpened = $refundAmountOpened;
        $this->refundStatus = $refundStatus;
        $this->refundStatusLoc = $refundStatusLoc;
        $this->invoiceDate = $invoiceDate;
        $this->inserted = $inserted;
        $this->confirmed = $confirmed;
        $this->cancelled = $cancelled;
        $this->doubleSpendingAlert = $doubleSpendingAlert;
        $this->acceptZeroConfirmations = $acceptZeroConfirmations;
        $this->itemName = $itemName;
        $this->accessToken = $accessToken;
        $this->sid = $sid;
        $this->paymentId = $paymentId;
        $this->customerDetails = $customerDetails;
    }

    public static function createFromArray(array $transaction): self
    {
        return new self(
            $transaction['state'],
            $transaction['status'],
            $transaction['status_loc'],
            $transaction['pos_id'],
            $transaction['invoice_currency'],
            $transaction['invoice_amount'],
            $transaction['currency'],
            $transaction['amount'],
            $transaction['amount_exchange'],
            $transaction['network_processing_fee'],
            $transaction['address'],
            $transaction['type'],
            $transaction['type_loc'],
            $transaction['payment'],
            $transaction['refund'],
            $transaction['refund_amount_opened'] !== null ? (string) $transaction['refund_amount_opened'] : null,
            $transaction['refund_status'],
            $transaction['refund_status_loc'],
            $transaction['invoice_date'],
            $transaction['inserted'],
            $transaction['confirmed'],
            $transaction['cancelled'],
            $transaction['double_spending_alert'],
            $transaction['accept_zero_confirmations'],
            $transaction['item_name'],
            $transaction['access_token'],
            $transaction['sid'],
            $transaction['payment_id'],
            isset($transaction['customer_details']) ? CustomerDetails::createFromArray($transaction['customer_details']) : null,
        );
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusLoc(): string
    {
        return $this->statusLoc;
    }

    public function getPosId(): string
    {
        return $this->posId;
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

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getAmountExchange(): ?string
    {
        return $this->amountExchange;
    }

    public function getNetworkProcessingFee(): string
    {
        return $this->networkProcessingFee;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTypeLoc(): string
    {
        return $this->typeLoc;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function getRefund(): ?string
    {
        return $this->refund;
    }

    public function getRefundAmountOpened(): ?string
    {
        return $this->refundAmountOpened;
    }

    public function getRefundStatus(): ?string
    {
        return $this->refundStatus;
    }

    public function getRefundStatusLoc(): ?string
    {
        return $this->refundStatusLoc;
    }

    public function getInvoiceDate(): ?string
    {
        return $this->invoiceDate;
    }

    public function getInserted(): string
    {
        return $this->inserted;
    }

    public function getConfirmed(): ?string
    {
        return $this->confirmed;
    }

    public function getCancelled(): ?string
    {
        return $this->cancelled;
    }

    public function getDoubleSpendingAlert(): ?string
    {
        return $this->doubleSpendingAlert;
    }

    public function isAcceptZeroConfirmations(): bool
    {
        return $this->acceptZeroConfirmations;
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function getCustomerDetails(): ?CustomerDetails
    {
        return $this->customerDetails;
    }

    public function toArray(): array
    {
        return [
            'state' => $this->state,
            'status' => $this->status,
            'status_loc' => $this->statusLoc,
            'pos_id' => $this->posId,
            'invoice_currency' => $this->invoiceCurrency,
            'invoice_amount' => $this->invoiceAmount,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'amount_exchange' => $this->amountExchange,
            'network_processing_fee' => $this->networkProcessingFee,
            'address' => $this->address,
            'type' => $this->type,
            'type_loc' => $this->typeLoc,
            'payment' => $this->payment,
            'refund' => $this->refund,
            'refund_amount_opened' => $this->refundAmountOpened,
            'refund_status' => $this->refundStatus,
            'refund_status_loc' => $this->refundStatusLoc,
            'invoice_date' => $this->invoiceDate,
            'inserted' => $this->inserted,
            'confirmed' => $this->confirmed,
            'cancelled' => $this->cancelled,
            'double_spending_alert' => $this->doubleSpendingAlert,
            'accept_zero_confirmations' => $this->acceptZeroConfirmations,
            'item_name' => $this->itemName,
            'access_token' => $this->accessToken,
            'sid' => $this->sid,
            'payment_id' => $this->paymentId,
            'customer_details' => $this->customerDetails !== null ? $this->customerDetails->toArray() : null,
        ];
    }
}
