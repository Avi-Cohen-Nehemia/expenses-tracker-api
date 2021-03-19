<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class ConvertCurrency
{
    public static function convert(float $amountInGBP, string $desiredCurrency)
    {
        $response = Http::get("https://api.exchangeratesapi.io/latest?base=GBP");

        $rate = $response->json()["rates"][$desiredCurrency];

        $convertedAmount =  $amountInGBP * $rate;

        return floatval(number_format($convertedAmount, 2));
    }
}
