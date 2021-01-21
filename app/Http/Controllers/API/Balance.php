<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use App\Income;
use App\Http\Controllers\API\Expenses;
use App\Http\Controllers\API\Incomes;
use App\Http\Requests\API\ExpenseRequest;
use NumberFormatter;

class Balance extends Controller
{
    public function getBalance()
    {
        $balance = Incomes::totalIncome() - Expenses::totalExpense();

        $format = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
        $formattedBalance = $format->formatCurrency($balance, "GBP");

        return response()->json(['data' => [
            'balance' => $formattedBalance,
        ]]);
    }
}
