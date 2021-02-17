<?php

namespace App\Utility;

class FormatToCurrency
{
    public static function toCurrency(float $amount) : string
    {
        $format = new \NumberFormatter( 'en_GB', \NumberFormatter::CURRENCY );
        $formattedAmount = $format->formatCurrency($amount, "GBP");

        return $formattedAmount;
    }
}
