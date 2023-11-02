<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetTransactions;

class CustomerDetailsAddress
{
    private string $firstName;

    private string $lastName;

    private ?string $company;

    private string $addressLine1;

    private ?string $addressLine2;

    private string $postalCode;

    private string $city;

    private string $country;

    private ?string $nationality;

    public function __construct(
        string $firstName,
        string $lastName,
        ?string $company,
        string $addressLine1,
        ?string $addressLine2,
        string $postalCode,
        string $city,
        string $country,
        ?string $nationality
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
        $this->nationality = $nationality;
    }

    public static function createFromArray(array $contact): self
    {
        return new self(
            $contact['first_name'],
            $contact['last_name'],
            $contact['company'],
            $contact['address_line_1'],
            $contact['address_line_2'],
            $contact['postal_code'],
            $contact['city'],
            $contact['country'],
            $contact['nationality']
        );
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'company' => $this->company,
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
            'nationality' => $this->nationality,
        ];
    }
}
