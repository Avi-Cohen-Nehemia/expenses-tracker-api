<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use App\Utility\Balance;
use App\Utility\FormatToCurrency;
use App\Utility\UserFunds;

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
        // user funds stats
        $balance = UserFunds::calculateBalance($this->transactions);
        $totalIncome = UserFunds::calculateIncome($this->transactions);
        $totalExpense = UserFunds::calculateExpense($this->transactions);
        $totalExpenseByCategory = UserFunds::calculateByCategory($this->transactions);

        //formatted to currency user funds stats
        $formattedBalance = FormatToCurrency::toCurrency($balance);
        $formattedTotalIncome = FormatToCurrency::toCurrency($totalIncome);
        $formattedTotalExpense = FormatToCurrency::toCurrency($totalExpense);

        // $collection = collect($this->transactions);
        // $sorted = $collection->sortByDesc('created_at');

        $transactions = $this->transactions->map(function ($transaction) {
            return new TransactionResource($transaction, "GBP");
        });
        // sort transactions from newest to oldest and use values() method
        // to prevent the result from being returned as an object
        $sorted = $transactions->sortByDesc('created_at')->values();

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "balance" => floatval($balance),
            "balance_with_currency" => $formattedBalance,
            "total_income" => floatval($totalIncome),
            "total_income_with_currency" => $formattedTotalIncome,
            "total_expense" => floatval($totalExpense),
            "total_expense_with_currency" => $formattedTotalExpense,
            "total_expense_by_category" => $totalExpenseByCategory,
            "transactions" => $sorted,
        ];
    }
}
