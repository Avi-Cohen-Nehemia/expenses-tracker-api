<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use App\Utility\FormatToCurrency;
use App\Utility\UserFunds;

class TransactionsByDateRangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactions = $this["transactions"]->map(function ($transaction) {
            return new TransactionResource($transaction);
        });

        $totalIncome = UserFunds::calculateIncome($transactions);
        $totalExpense = UserFunds::calculateExpense($transactions);
        $totalExpenseByCategory = UserFunds::calculateByCategory($transactions);

        return [
            "total_income" => floatval($totalIncome),
            "total_income_with_currency" => FormatToCurrency::toCurrency($totalIncome, $this["currency"]),
            "total_expense" => floatval($totalExpense),
            "total_expense_with_currency" => FormatToCurrency::toCurrency($totalExpense, $this["currency"]),
            "total_expense_by_category" => $totalExpenseByCategory,
            "transactions" => $transactions,
        ];
    }
}
