<?php

namespace App\Utility;

class Balance
{
    public static function calculateBalance($transactions) : float
    {
        $collection = collect($transactions);

        // Separate incomes and expenses into 2 arrays
        $income = $collection->filter(function ($transaction, $key) {
            return $transaction->type === "income";
        });

        $expense = $collection->filter(function ($transaction, $key) {
            return $transaction->type === "expense";
        });


        // Calculate their total separately
        $totalIncome = $income->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        $totalExpense = $expense->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        //return the calculated balance
        return $totalIncome - $totalExpense;
    }
}