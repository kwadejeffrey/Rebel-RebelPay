<?php

// config for Rebel/RebelPay
return [
    "publickey" => env('PAYSTACK_PUBLIC_KEY'),

    "secretkey" => env('PAYSTACK_SECRET_KEY'),

    "paystackurl" => env('PAYSTACK_PAYMENT_URL'),

    "merchantmail" => env('MERCHANT_EMAIL')
];
