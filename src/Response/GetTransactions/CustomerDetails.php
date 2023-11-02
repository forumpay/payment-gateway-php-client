<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetTransactions;

use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\CustomerDetailsAddress;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\CustomerDetailsContact;

class CustomerDetails
{
    private CustomerDetailsAddress $billingAddress;

    private CustomerDetailsContact $contact;

    private ?CustomerDetailsAddress $shippingAddress;

    public function __construct(
        CustomerDetailsAddress $billingAddress,
        CustomerDetailsContact $contact,
        ?CustomerDetailsAddress $shippingAddress
    ) {
        $this->billingAddress = $billingAddress;
        $this->contact = $contact;
        $this->shippingAddress = $shippingAddress;
    }

    public static function createFromArray(array $customerDetails): self
    {
        return new self(
            CustomerDetailsAddress::createFromArray($customerDetails['billing_address']),
            CustomerDetailsContact::createFromArray($customerDetails['contact']),
            isset($customerDetails['shipping_address']) ? CustomerDetailsAddress::createFromArray($customerDetails['shipping_address']) : null
        );
    }

    public function getBillingAddress(): CustomerDetailsAddress
    {
        return $this->billingAddress;
    }

    public function getContact(): CustomerDetailsContact
    {
        return $this->contact;
    }

    public function getShippingAddress(): ?CustomerDetailsAddress
    {
        return $this->shippingAddress;
    }

    public function toArray(): array
    {
        return [
            'billing_address' => $this->billingAddress->toArray(),
            'contact' => $this->contact->toArray(),
            'shipping_address' => $this->shippingAddress !== null ? $this->shippingAddress->toArray() : null,
        ];
    }
}
