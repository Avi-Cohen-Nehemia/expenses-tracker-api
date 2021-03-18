<?php

namespace App\Utility;
use NumberFormatter;

class FormatToCurrency
{
    public static function toCurrency(float $amount, string $currency = "GBP") : string
    {
        if ($currency === "GBP") {
            $format = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
            $formattedAmount = $format->formatCurrency($amount, $currency);

            return $formattedAmount;
        }

        $format = new NumberFormatter('en_GB', NumberFormatter::DECIMAL);
        $format->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

        $formattedAmount = $format->format($amount);

        return "{$currency} {$formattedAmount}";
    }
}
