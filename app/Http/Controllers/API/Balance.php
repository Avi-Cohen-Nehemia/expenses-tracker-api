<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use App\Income;
use App\Http\Controllers\API\Expenses;
use App\Http\Controllers\API\Incomes;
use App\Http\Requests\API\ExpenseRequest;

class Balance extends Controller
{
    public function getBalance()
    {
        $balance = Incomes::totalIncome() - Expenses::totalExpense();

        return $balance;
    }
}
