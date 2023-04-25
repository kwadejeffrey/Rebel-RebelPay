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

1. The customer is redirected to the payment provider's site.
- After customer completes the checkout form on your website, feed the package with the necessary data and the customer will be redirect to [paystack](https://paystack.com/) to complete payment.

2. The customer arrives on paystack platform
- After the customer is redirected to [paystack](https://paystack.com/), they can choose from the available payment options based on your account settings with [paystack](https://paystack.com/) and complete the transaction.

3. Customer is redirect to website
- After the customer has completed the transaction on [Paystack's](https://paystack.com/) website, they will be redirected back to a route that we have set up in our Laravel application instead of relying on [Paystack's](https://paystack.com/) callback webhook.

## Environment Variables

- `PAYSTACK_PUBLIC_KEY= insert your Paystack public key`
- `PAYSTACK_SECRET_KEY= insert your Paystack secret key`
- `PAYSTACK_PAYMENT_URL=https://api.paystack.co`
- `MERCHANT_EMAIL= kwadejeffrey@gmail.com`

## Usage/Examples

```php
$rebelPay = new Rebel\RebelPay();
echo $rebelPay->echoPhrase('Hello, Rebel!');
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Rebel\RebelPay\Facades\RebelPay;

class Controller extends BaseController
{
    public function paystackCheckout(Request $request)
    {
        //Let's validate form data
        $validated_data = $request->validate([
            'first_name' => 'required', 
            'last_name' => 'required',
            'email' => 'required', 
            'amount' => 'required',
        ]);

        /**
         * Let's build our Paystack data
         * Always multiply amount by 100
         * First, Last and phone name are optional for direct payments
         * callback_url is optional since we can set a default callback on Paystacks' dashboard but if we set a value for it, it'll overwrite the dashboard default value.
         * I personally prefer setting a value in my code
         * You use any of your applications web routes' name as the callback_url
         */
        $data = [
            'email' => $validated_data->email,
            'amount' => $validated_data->amount * 100,
            'first_name' => $validated_data->first_name,
            'last_name' => $validated_data->last_name,
            'phone' => $validated_data->tel,
            'callback_url' => route('callback')
        ];

        /**
         * Let's call Rebelpay with the makePayment method
         * And let's inject the data array into the method
         * We'll be redirect to the paystack website to complete transaction
         */
        $res = RebelPay::makePayment($data);
        return view('rebelPay.pageOne');
    }

     public function getCallbackData()
    {
        /**
         * In the method that corresponds to the callback url
         * We'll call the callbackData on rebelPay 
         * An object is returned (Status, Message and Data)
         * Status has a value of "True"
         * Message has a value of "Verification successful"
         * And data returns an object of the transactions data
         * The important keys to note in the data attribute is (status, reference, amount, authorization, customer, channel )
         * You can't deploy your code is diverse ways using these attributes
         * You can clear the cart from DB or simply invalidate it depending on your DB structure
         */
        $res = RebelPay::callbackData();
        dd($res);
        //You could do something like this
        if($res->data->status){
            Cart::where('user_id', $user_id)->delete();
        }
        //You could pass the status as a session
        return redirect('/')->with('message', $res->data->status);
    }

    /**
     * We'll use this function to return all our transactions from Paystack
     */
    public function getAllTransactionsFromPaystack()
    {
        /**
         * By default this we'll return a status, message, data and meta attributes
         * The data is what we need so pass it to the blade view or vue component
         * This method return the 100 transactions, you can alter the number
         * This method holds two arguments ($perPage = 100, $page = 1)
         * You can adjust them as you see fit 
         */
        $res = RebelPay::getAllTransactions();
        dd($res);
        return view('rebelPay.pageOne', [
            'transactions' => $res->data
        ]);
    }


    /**
     * We'll use this function to return all our Failed transactions from Paystack
     */
    public function getFailedTransactionsFromPaystack()
    {
        /**
         * By default this we'll return a status, message, data and meta attributes
         * The data is what we need so pass it to the blade view or vue component
         * This method return the 100 transactions, you can alter the number
         * This method holds two arguments ($perPage = 100, $page = 1)
         * You can adjust them as you see fit 
         */
        $res = RebelPay::getFailedTransactions();
        dd($res);
        return view('rebelPay.pageOne', [
            'transactions' => $res->data
        ]);
    }


    /**
     * We'll use this function to return all our successful transactions from Paystack
     */
    public function getSuccessfulTransactionsFromPaystack()
    {
        /**
         * By default this we'll return a status, message, data and meta attributes
         * The data is what we need so pass it to the blade view or vue component
         * This method return the 100 transactions, you can alter the number
         * This method holds two arguments ($perPage = 100, $page = 1)
         * You can adjust them as you see fit 
         */
        $res = RebelPay::getSuccessfulTransactions();
        dd($res);
        return view('rebelPay.pageOne', [
            'transactions' => $res->data
        ]);
    }


    /**
     * We'll use this function to return all our abandoned transactions from Paystack
     */
    public function getAbandonedTransactionsFromPaystack()
    {
        /**
         * By default this we'll return a status, message, data and meta attributes
         * The data is what we need so pass it to the blade view or vue component
         * This method return the 100 transactions, you can alter the number
         * This method holds two arguments ($perPage = 100, $page = 1)
         * You can adjust them as you see fit 
         */
        $res = RebelPay::getAbandonedTransactions();
        dd($res);
        return view('rebelPay.pageOne', [
            'transactions' => $res->data
        ]);
    }

    /**
     * Method to get a targeted transaction from Paystack
     */
    public function getTransactionFromPaystack(int $id)
    {
        /**
         * Pass the transaction id as an argument
         * e.g 2749916096
         */
        $res = RebelPay::getTransaction($id);
    }


}


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
