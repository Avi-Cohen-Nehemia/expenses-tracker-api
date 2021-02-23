<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
// use NumberFormatter;
use App\Utility\Balance;
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

        // $format = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
        // $formattedWithCurrency = $format->formatCurrency($amount, "GBP");
        $formattedWithType = $this->type === 'income' ? "£{$amount}" : "- £{$amount}";

        $formattedDate = $this->created_at->format('d-m-Y');

        $transactionsToDate = DB::table("transactions")
            ->where("user_id", $this->user_id)
            ->whereBetween('created_at', ["2020-01-01", $this->created_at])
            ->get();
        $balanceAtTheTime = Balance::calculateBalance($transactionsToDate) + $amount;
        // $formattedBalanceAtTheTime = $format->formatCurrency($balanceAtTheTime, "GBP");

        return[
            "transaction_id" => $this->id,
            "amount" => $this->amount,
            "amount_with_currency" => $formattedWithType,
            "type" => $this->type,
            "category" => $this->category,
            "created_at" => $formattedDate,
            "unformatted_created_at" => $this->created_at,
            "balance_at_the_time" => "£{$balanceAtTheTime}"
        ];
    }
}
