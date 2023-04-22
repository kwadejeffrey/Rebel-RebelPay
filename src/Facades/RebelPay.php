<?php

namespace Rebel\RebelPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rebel\RebelPay\RebelPay
 */
class RebelPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rebel\RebelPay\RebelPay::class;
    }
}
