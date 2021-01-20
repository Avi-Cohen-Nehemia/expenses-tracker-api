<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Income;
use App\Http\Requests\API\IncomeRequest;

class Incomes extends Controller
{
    public function index()
    {
        return Income::all();
    }

    public static function totalIncome() : float
    {
        $collection = collect(Income::all());

        $total = $collection->reduce(function ($acc, $value) {
            return $acc + $value->amount;
        }, 0);

        return $total;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        return Income::create($data);
    }

    public function show(Income $income)
    {
        return $income;
    }

    public function update(Request $request, Income $income)
    {
        $data = $request->all();

        $income->fill($data)->save();

        return $income;
    }

    public function destroy(Income $income)
    {
        $income->delete();
        
        return response(null, 204);
    }
}
