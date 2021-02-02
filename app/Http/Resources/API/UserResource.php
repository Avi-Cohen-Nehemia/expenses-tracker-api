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
        $balance = UserFunds::calculateBalance($this->transactions);
        $totalIncome = UserFunds::calculateIncome($this->transactions);
        $totalExpense = UserFunds::calculateExpense($this->transactions);
        $totalExpenseByCategory = UserFunds::calculateByCategory($this->transactions);

        $collection = collect($this->transactions);
        $sorted = $collection->sortByDesc('created_at');

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "balance" => $balance,
            "total_income" => $totalIncome,
            "total_expense" => $totalExpense,
            "total_expense_by_category" => $totalExpenseByCategory,
            "transactions" => TransactionResource::collection($sorted),
        ];
    }
}
