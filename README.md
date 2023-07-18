# Payment Gateway Webhost PHP Client

PHP Client for interacting with Payment Gateway Webhost API

# Install

Run `composer require forumpay/payment-gateway-php-client`

# Usage

Example usage for getting currency list.

```php
use ForumPay\PaymentGateway\PHPClient\PaymentGatewayApi;

$paymentGatewayApi = new PaymentGatewayApi(
    $paymentGatewayUri,
    $apiUser,
    $apiSecret,
    $userAgentApplicationIdentifier
);

try {
    $getCurrencyListResponse = $paymentGatewayApi->getCurrencyList('EUR');
} catch (ApiExceptionInterface $exception) {
    //TODO: handle the exception
}
```
**Where:**

`$paymentGatewayUri` is *Service URL* as per API documentation

`$apiUser` and `$apiSecret` are credentials for *Payment Gateway API Keys*

`$userAgentApplicationIdentifier` represents the user agent application identifier for HTTP the client. Example: (*'MyPaymentApp/1.0.0'*)

![Payment Gateway API Keys](docs/readme/api-key.png)

# Available endpoints

- GetRate
- StartPayment
- CheckPayment
- GetTransactions
- CancelPayment
- GetCurrencyList

For corresponding methods refer to `PaymentGatewayApiInterface` in `src/PaymentGatewayApiInterface.php`
