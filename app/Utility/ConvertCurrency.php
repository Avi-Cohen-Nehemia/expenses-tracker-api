<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class ConvertCurrency
{
    public static function convert(float $amountInGBP, string $desiredCurrency = "GBP")
    {
        // get the currency exchange rate from a 3rd party API
        $response = Http::get("https://api.exchangeratesapi.io/latest?base=GBP");
        $rate = $response->json()["rates"][$desiredCurrency];

        // convert to amount in the desired currency and return a float formatted to . 2 decimal
        $convertedAmount = number_format($amountInGBP * $rate, 2, '.', '');
        return floatval($convertedAmount);
    }
}

// class ConvertCurrency
// {
//     private $desiredCurrency;
//     private $amountInGBP;

//     public function __construct(float $amountInGBP, string $desiredCurrency)
//     {
//         $this->amountInGBP = $amountInGBP;
//         $this->desiredCurrency = $desiredCurrency;
//     }

//     public function getConversionRate() : float
//     {
//         $response = Http::get("https://api.exchangeratesapi.io/latest?base=GBP");

//         $rate = $response->json()["rates"][$this->desiredCurrency];

//         return $rate;
//     }

//     public function convert() : float
//     {
//         $rate = getConversionRate();

//         return $this->amountInGBP * $rate;
//     }
// }