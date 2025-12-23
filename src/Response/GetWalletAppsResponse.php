<?php

declare(strict_types=1);

namespace ForumPay\PaymentGateway\PHPClient\Response;

use ForumPay\PaymentGateway\PHPClient\Http\HttpResult;
use ForumPay\PaymentGateway\PHPClient\Response\GetWalletApps\WalletApp;

class GetWalletAppsResponse
{
    private array $walletApps;

    public function __construct(
        array $walletApps = []
    ) {
        $this->walletApps = $walletApps;
    }

    public static function createFromHttpResult(HttpResult $httpResult): self
    {
        return new self(
            array_map(
                fn (array $walletApp) => WalletApp::createFromArray($walletApp),
                $httpResult->getResponse()
            )
        );
    }

    public function getWalletApps(): array
    {
        return $this->walletApps;
    }

    public function toArray(): array
    {
        return [
            'wallet_apps' => array_map(
                fn (WalletApp $walletApp) => $walletApp->toArray(),
                $this->walletApps
            ),
        ];
    }
}
