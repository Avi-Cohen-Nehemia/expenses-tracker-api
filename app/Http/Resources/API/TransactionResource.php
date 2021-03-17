<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
// use NumberFormatter;
use App\Utility\Balance;
use App\Utility\FormatToCurrency;
use Illuminate\Support\Facades\DB;

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
        $amountWithCurrency = FormatToCurrency::toCurrency($amount);

        $amountFormattedWithType = $this->type === 'income' ? $amountWithCurrency : "- {$amountWithCurrency}";

        $formattedDate = $this->created_at->format('d-m-Y');

        $transactionsToDate = DB::table("transactions")
            ->where("user_id", $this->user_id)
            ->whereBetween('created_at', ["2020-01-01", $this->created_at])
            ->get();
        $balanceAtTheTime = Balance::calculateBalance($transactionsToDate);

        return[
            "transaction_id" => $this->id,
            "amount" => $this->amount,
            "amount_with_currency" => $amountFormattedWithType,
            "type" => $this->type,
            "category" => $this->category,
            "created_at" => $formattedDate,
            "unformatted_created_at" => $this->created_at,
            "balance_at_the_time" => FormatToCurrency::toCurrency($balanceAtTheTime)
        ];
    }
}
