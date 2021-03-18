<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use App\Utility\FormatToCurrency;
use App\Utility\UserFunds;
use App\Utility\Balance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionsByDateRangeResource extends JsonResource
{
    private $data;

    public function __construct($transactions, $data)
    {
        parent::__construct($transactions);
        $this->transactions = $transactions;
        $this->currency = $data["currency"];
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
            return new TransactionResource($transaction);
        });

        $today = Carbon::now()->toDateString();
        $transactionsToDate = DB::table("transactions")
            ->where("user_id", $this->user_id)
            ->whereBetween('created_at', ["2020-01-01", $today])
            ->get();
        $balance = Balance::calculateBalance($transactionsToDate);

        $totalIncome = UserFunds::calculateIncome($transactions);
        $totalExpense = UserFunds::calculateExpense($transactions);
        $totalExpenseByCategory = UserFunds::calculateByCategory($transactions);

        return [
            "balance" => floatval($balance),
            "balance_with_currency" => FormatToCurrency::toCurrency($balance, $this->currency),
            "total_income" => floatval($totalIncome),
            "total_income_with_currency" => FormatToCurrency::toCurrency($totalIncome, $this->currency),
            "total_expense" => floatval($totalExpense),
            "total_expense_with_currency" => FormatToCurrency::toCurrency($totalExpense, $this->currency),
            "total_expense_by_category" => $totalExpenseByCategory,
            "transactions" => $transactions,
        ];
    }
}
