<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use NumberFormatter;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactions = collect($this->transactions);

        $income = $transactions->filter(function ($transaction, $key) {
            return $transaction->type === "income";
        });

        $totalIncome = $income->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        $expense = $transactions->filter(function ($transaction, $key) {
            return $transaction->type === "expense";
        });

        $totalExpense = $expense->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        $balance = $totalIncome - $totalExpense;

        $format = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
        $formattedBalance = $format->formatCurrency($balance, "GBP");

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "balance" => $formattedBalance,
            "transactions" => TransactionResource::collection($this->transactions),
        ];
    }
}
