<?php

namespace App\Utility;
use Illuminate\Support\Collection;
// use App\Utility\FormatToCurrency;

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

    public static function calculateByCategory($transactions)
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

        foreach ($totals as $totalsKey => $array) {

            foreach ($array as $key => $value) {

                $acc = 0;

                foreach ($value as $key => $amount) {
                    $acc += $amount;
                }

                $reducedTotal = [
                    "category" => key($array),
                    "amount" => $acc,
                    "amount_with_currency" => "£{$acc}"
                ];

                $reducedTotals[] = $reducedTotal;
            }
        }

        return $reducedTotals;
    }
}

// $test = [
//     [
//         "amount" => 22,
//         "category" => "rent",
//         "type" => "expense"
//     ],
//     [
//         "amount" => 34,
//         "category" => "bills",
//         "type" => "expense"
//     ],
//     [
//         "amount" => 50,
//         "category" => "bills",
//         "type" => "expense"
//     ],
//     [
//         "amount" => 54,
//         "category" => "paycheck",
//         "type" => "income"
//     ],
//     [
//         "amount" => 100,
//         "category" => "rent",
//         "type" => "expense"
//     ]
// ];

// var_dump(UserFunds::calculateByCategory($test));
