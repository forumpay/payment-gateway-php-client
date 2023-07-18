<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\CheckPayment;

class Underpayment
{
    private string $address;

    private string $missingAmount;

    private string $qr;

    private string $qrAlt;

    private string $qrImg;

    private string $qrAltImg;

    public function __construct(
        string $address,
        string $missingAmount,
        string $qr,
        string $qrAlt,
        string $qrImg,
        string $qrAltImg
    ) {
        $this->address = $address;
        $this->missingAmount = $missingAmount;
        $this->qr = $qr;
        $this->qrAlt = $qrAlt;
        $this->qrImg = $qrImg;
        $this->qrAltImg = $qrAltImg;
    }

    public static function createFromArray(array $underpayment): self
    {
        return new self(
            $underpayment['address'],
            $underpayment['missing_amount'],
            $underpayment['qr'],
            $underpayment['qr_alt'],
            $underpayment['qr_img'],
            $underpayment['qr_alt_img']
        );
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getMissingAmount(): string
    {
        return $this->missingAmount;
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

    public function toArray(): array
    {
        return [
            'address' => $this->address,
            'missingAmount' => $this->missingAmount,
            'qr' => $this->qr,
            'qrAlt' => $this->qrAlt,
            'qrImg' => $this->qrImg,
            'qrAltImg' => $this->qrAltImg,
        ];
    }
}
