<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetTransactions;

use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\CustomerDetailsAddress;
use ForumPay\PaymentGateway\PHPClient\Response\GetTransactions\CustomerDetailsContact;
use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayload;

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

    public static function createFromArray(array $customerDetails, string $path = '$'): self
    {
        $payload = ResponsePayload::fromArray($customerDetails, $path);
        $billingAddress = $payload->requiredObject('billing_address');
        $contact = $payload->requiredObject('contact');
        $shippingAddress = $payload->optionalObject('shipping_address');

        return new self(
            CustomerDetailsAddress::createFromArray($billingAddress->getData(), $billingAddress->getPath()),
            CustomerDetailsContact::createFromArray($contact->getData(), $contact->getPath()),
            $shippingAddress !== null ? CustomerDetailsAddress::createFromArray($shippingAddress->getData(), $shippingAddress->getPath()) : null
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
