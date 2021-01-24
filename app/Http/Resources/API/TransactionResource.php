<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use NumberFormatter;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $amount = $this->amount;

        $format = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
        $formattedWithCurrency = $format->formatCurrency($amount, "GBP");
        $formattedWithType = $this->type === 'income' ? "+{$formattedWithCurrency}" : "-{$formattedWithCurrency}";

        return[
            "amount" => $formattedWithType,
            "type" => $this->type,
            "category" => $this->category,
            "created_at" => $this->created_at
        ];
    }
}
