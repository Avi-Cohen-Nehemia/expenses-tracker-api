<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

// class ConvertCurrency
// {
//     public static function convert(float $amountInGBP, string $desiredCurrency = "GBP")
//     {
//         // get the currency exchange rate from a 3rd party API
//         $response = Http::get("https://api.exchangeratesapi.io/latest?base=GBP");
//         $rate = $response->json()["rates"][$desiredCurrency];

//         // convert to amount in the desired currency and return a float formatted to . 2 decimal
//         $convertedAmount = number_format($amountInGBP * $rate, 2, '.', '');
//         return floatval($convertedAmount);
//     }
// }

class ConvertCurrency
{
    public static function getConversionRate($desiredCurrency) : float
    {
        $response = Http::get("https://api.exchangeratesapi.io/latest?base=GBP");

        $rate = $response->json()["rates"][$desiredCurrency];

        return $rate;
    }

    public $amountInGBP;

    public function __construct(float $amountInGBP)
    {
        $this->amountInGBP = $amountInGBP;
    }

    public function convert($rate) : float
    {
        $convertedAmount = $this->amountInGBP * $rate;

        $formattedAmount = number_format($convertedAmount, 2, '.', '');

        return floatval($formattedAmount);
    }
}