# Paystack Laravel package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rebel/rebel-rebelpay.svg?style=flat-square)](https://packagist.org/packages/rebel/rebel-rebelpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/rebel/rebel-rebelpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/RebelNii/Rebel-RebelPay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rebel/rebel-rebelpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/RebelNii/Rebel-RebelPay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rebel/rebel-rebelpay.svg?style=flat-square)](https://packagist.org/packages/rebel/rebel-rebelpay)

This is a Laravel composer package that simplifies accepting payments on [Paystack](https://paystack.com).

## Installation

You can install the package via composer:

```bash
composer require rebel/rebel-rebelpay
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="rebel-rebelpay-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="rebel-rebelpay-config"
```

This is the contents of the published config file:

```php
return [
    'publickey' => env('PAYSTACK_PUBLIC_KEY'),

    'secretkey' => env('PAYSTACK_SECRET_KEY'),

    'paystackurl' => env('PAYSTACK_PAYMENT_URL'),

    'merchantmail' => env('MERCHANT_EMAIL'),
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="rebel-rebelpay-views"
```

## Features
- Payments
- Get all transactions records from Paystack
- Get single transaction record from Paystack
- Fetch all successful transaction Paystack
- Fetch all failed transaction Paystack
- Fetch all abandoned transaction Paystack
- Export transactions in csv format
- Fetch transactions history

## Workflow of this package

# The customer is redirected to the payment provider's site.
- After customer completes the checkout form on your website, feed the package with the necessary data and the customer will be redirect to [paystack](https://paystack.com/) to complete payment.

# The customer arrives on paystack platform
- After the customer is redirected to [paystack](https://paystack.com/), they can choose from the available payment options based on your account settings with [paystack](https://paystack.com/) and complete the transaction.

# Customer is redirect to website
- After the customer has completed the transaction on [Paystack's](https://paystack.com/) website, they will be redirected back to a route that we have set up in our Laravel application instead of relying on [Paystack's](https://paystack.com/) callback webhook.

## Environment Variables

`PAYSTACK_PUBLIC_KEY= insert your Paystack public key`
`PAYSTACK_SECRET_KEY= insert your Paystack secret key`
`PAYSTACK_PAYMENT_URL=https://api.paystack.co`
`MERCHANT_EMAIL= kwadejeffrey@gmail.com`

## Usage/Examples

```php
$rebelPay = new Rebel\RebelPay();
echo $rebelPay->echoPhrase('Hello, Rebel!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kwade Jeffrey](https://github.com/RebelNii)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
