<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response\GetWalletApps;

class WalletApp
{
    private string $id;

    private string $name;

    private ?string $image;

    private ?string $imageDarkmode;

    public function __construct(
        string $id,
        string $name,
        ?string $image,
        ?string $imageDarkmode
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->imageDarkmode = $imageDarkmode;
    }

    public static function createFromArray(array $walletApp): self
    {
        return new self(
            $walletApp['id'],
            $walletApp['name'],
            $walletApp['image'] ?? null,
            $walletApp['image_darkmode'] ?? null
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getImageDarkmode(): ?string
    {
        return $this->imageDarkmode;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'image_darkmode' => $this->imageDarkmode,
        ];
    }
}
