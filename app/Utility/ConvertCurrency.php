<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;

class ConvertCurrency
{
    public static function getConversionRate($desiredCurrency) : float
    {
        $response = Http::get("https://api.exchangerate.host/latest?base=GBP");

        $rate = $response->json()["rates"][$desiredCurrency];

        return $rate;
    }

    public $amountInGBP;

    public function __construct(float $amountInGBP)
    {
        $this->amountInGBP = $amountInGBP;
    }

    public function convert(float $rate) : float
    {
        $convertedAmount = $this->amountInGBP * $rate;

        $formattedAmount = number_format($convertedAmount, 2, '.', '');

        return floatval($formattedAmount);
    }
}