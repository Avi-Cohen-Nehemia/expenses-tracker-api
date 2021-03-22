<?php

namespace App\Utility;

use NumberFormatter;
use App\Utility\ConvertCurrency;

class FormatToCurrency
{
    public static function toCurrency(float $amount, float $rate, string $currency = "GBP") : string
    {
        $transaction = new ConvertCurrency($amount);
        $convertedAmount = $transaction->convert($rate);

        if ($currency === "GBP") {
            $format = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
            $formattedAmount = $format->formatCurrency($convertedAmount, $currency);

            return $formattedAmount;
        }

        $format = new NumberFormatter('en_GB', NumberFormatter::DECIMAL);
        $format->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

        $formattedAmount = $format->format($convertedAmount);

        return "{$formattedAmount} {$currency}";
    }
}
