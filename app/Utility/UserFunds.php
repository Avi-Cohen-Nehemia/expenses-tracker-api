<?php

namespace App\Utility;
use Illuminate\Support\Collection;
use App\Utility\FormatToCurrency;
use App\Utility\ConvertCurrency;

class UserFunds
{
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

    public static function calculateBalance($transactions) : string
    {
        $totalExpense = UserFunds::calculateExpense($transactions);
        $totalIncome = UserFunds::calculateIncome($transactions);

        $balance = $totalIncome - $totalExpense;

        return $balance;
    }

    public static function calculateByCategory($transactions, $currency = "GBP")
    {
        // take the user's transactions and make a list of all the categories the user made an expense on
        $categories = [];

        foreach ($transactions as $index => $transaction) {

            // make sure to record only "expense" categories and not repeat categories already recorded
            if ($transaction["type"] === "expense" && !in_array($transaction["category"], $categories)) {
                $categories[] = $transaction["category"];
            }
        }


        // figure out which transactions belong to which category
        $totals = [];

        foreach ($categories as $categoryKey => $category) {

            $totals[] = [$category => []];

            foreach ($transactions as $transactionKey => $transaction) {

                if ($transaction["category"] === $category) {

                    $totals[$categoryKey][$category][] = $transaction["amount"];
                }
            }
        }


        // calculate the total of how much the user spent on each category
        // and convert the result to the requested currency
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
