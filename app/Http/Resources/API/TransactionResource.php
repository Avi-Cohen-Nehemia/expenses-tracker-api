<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Utility\Balance;
use App\Utility\FormatToCurrency;
use App\Utility\ConvertCurrency;
use Illuminate\Support\Facades\DB;

class TransactionResource extends JsonResource
{
    private $currency;

    public function __construct($transaction, $rate = 1, $currency = "GBP")
    {
        parent::__construct($transaction);
        $this->rate = $rate;
        $this->currency = $currency;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactionAmount = new ConvertCurrency($this->amount);
        $amountWithCurrency = FormatToCurrency::toCurrency($transactionAmount->amountInGBP, $this->rate, $this->currency);

        $amountFormattedWithType = $this->type === 'income' ? $amountWithCurrency : "- {$amountWithCurrency}";

        $formattedDate = $this->created_at->format('d-m-Y');

        $transactionsToDate = DB::table("transactions")
            ->where("user_id", $this->user_id)
            ->whereBetween('created_at', ["2020-01-01", $this->created_at])
            ->get();
        $balanceAtTheTime = Balance::calculateBalance($transactionsToDate);

        return[
            "transaction_id" => $this->id,
            "amount" => $transactionAmount->convert($this->rate),
            "amount_with_currency" => $amountFormattedWithType,
            "type" => $this->type,
            "category" => $this->category,
            "created_at" => $formattedDate,
            "unformatted_created_at" => $this->created_at,
            "balance_at_the_time" => FormatToCurrency::toCurrency($balanceAtTheTime, $this->rate, $this->currency)
        ];
    }
}
