<?php

namespace App\Helpers;

class CurrencyHelper
{
    const CURRENCY_CODE_EURO = 'EUR';

    public static function isEuroCurrency(string $currencyCode): bool
    {
        return $currencyCode === self::CURRENCY_CODE_EURO;
    }
}