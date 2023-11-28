<?php

namespace SePay\SePay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SePay\SePay\SePay
 */
class SePay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SePay\SePay\SePay::class;
    }
}
