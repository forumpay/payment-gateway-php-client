<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetTransactions;

use ForumPay\PaymentGateway\PHPClient\Response\ResponsePayload;

class CustomerDetailsContact
{
    private string $phoneNumber;

    private string $emailAddress;

    public function __construct(
        string $phoneNumber,
        string $emailAddress
    ) {
        $this->phoneNumber = $phoneNumber;
        $this->emailAddress = $emailAddress;
    }

    public static function createFromArray(array $contact, string $path = '$'): self
    {
        $payload = ResponsePayload::fromArray($contact, $path);

        return new self(
            $payload->requiredString('phone_number'),
            $payload->requiredString('email_address')
        );
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function toArray(): array
    {
        return [
            'phone_number' => $this->phoneNumber,
            'email_address' => $this->emailAddress,
        ];
    }
}
