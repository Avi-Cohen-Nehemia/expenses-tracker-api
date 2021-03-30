<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use App\Utility\FormatToCurrency;
use App\Utility\ConvertCurrency;
use App\Utility\UserFunds;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FilteredTransactionsResource extends JsonResource
{
    private $data;

    public function __construct($transactions, $data)
    {
        parent::__construct($transactions);
        $this->transactions = $transactions;
        $this->currency = $data["currency"];
        $this->rate = $data["rate"];
        $this->user_id = $data["user_id"];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactions = $this->transactions->map(function ($transaction) {
            return new TransactionResource($transaction, $this->rate, $this->currency);
        });

        $today = Carbon::now()->toDateString();
        $transactionsToDate = DB::table("transactions")
            ->where("user_id", $this->user_id)
            ->whereBetween('created_at', ["2020-01-01", $today])
            ->get();
        $balance = UserFunds::calculateBalance($transactionsToDate);
        $balanceConversion = new ConvertCurrency($balance);

        $totalIncome = UserFunds::calculateIncome($transactions);
        $totalIncomeConversion = new ConvertCurrency($totalIncome);

        $totalExpense = UserFunds::calculateExpense($transactions);
        $totalExpenseConversion = new ConvertCurrency($totalExpense);

        $totalExpenseByCategory = UserFunds::calculateByCategory($transactions, $this->currency);

        return [
            "balance" => $balanceConversion->convert($this->rate),
            "balance_with_currency" => FormatToCurrency::toCurrency($balance, $this->rate, $this->currency),
            "total_income" => $totalIncomeConversion->convert($this->rate),
            "total_income_with_currency" => FormatToCurrency::toCurrency($totalIncome, $this->rate, $this->currency),
            "total_expense" => $totalExpenseConversion->convert($this->rate),
            "total_expense_with_currency" => FormatToCurrency::toCurrency($totalExpense, $this->rate, $this->currency),
            "total_expense_by_category" => $totalExpenseByCategory,
            "transactions" => $transactions,
        ];
    }
}
