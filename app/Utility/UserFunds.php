<?php

namespace App\Utility;
use Illuminate\Support\Collection;
use App\Utility\FormatToCurrency;
use App\Utility\ConvertCurrency;

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

        return $balance;
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

        return $totalIncome;
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

        return $totalExpense;
    }

    public static function calculateByCategory($transactions, $currency = "GBP")
    {
        $categories = [];

        foreach ($transactions as $index => $transaction) {

            if ($transaction["type"] === "expense" && !in_array($transaction["category"], $categories)) {
                $categories[] = $transaction["category"];
            }
        }


        $totals = [];

        foreach ($categories as $categoryKey => $category) {

            $totals[] = [$category => []];

            foreach ($transactions as $transactionKey => $transaction) {

                if ($transaction["category"] === $category) {

                    $totals[$categoryKey][$category][] = $transaction["amount"];
                }
            }
        }


        $reducedTotals = [];
        $rate = ConvertCurrency::getConversionRate($currency);

        foreach ($totals as $totalsKey => $array) {

            foreach ($array as $key => $value) {

                $acc = 0;

                foreach ($value as $key => $amount) {
                    $acc += $amount;
                }

                $total = new ConvertCurrency($acc);
                $convertedTotal = $total->convert($rate);

                $reducedTotal = [
                    "category" => key($array),
                    "amount" => $convertedTotal,
                    "amount_with_currency" => FormatToCurrency::toCurrency($total->amountInGBP, $rate, $currency)
                ];

                $reducedTotals[] = $reducedTotal;
            }
        }

        return $reducedTotals;
    }
}
