<?php

namespace App\Utility;
use App\Utility\FormatToCurrency;

class UserFunds
{
    public static function calculateBalance($transactions) : string
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

        $balance = $totalIncome - $totalExpense;

        $formattedBalance = FormatToCurrency::toCurrency($balance);

        return $formattedBalance;
    }

    public static function calculateIncome($transactions) : string
    {
        $collection = collect($transactions);

        $income = $collection->filter(function ($transaction, $key) {
            return $transaction->type === "income";
        });

        $totalIncome = $income->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        $formattedTotalIncome = FormatToCurrency::toCurrency($totalIncome);

        return $formattedTotalIncome;
    }

    public static function calculateExpense($transactions) : string
    {
        $collection = collect($transactions);

        $expense = $collection->filter(function ($transaction, $key) {
            return $transaction->type === "expense";
        });

        $totalExpense = $expense->reduce(function ($acc, $transaction) {
            return $acc + $transaction->amount;
        }, 0);

        $formattedTotalExpense = FormatToCurrency::toCurrency($totalExpense);

        return $formattedTotalExpense;
    }
}
