<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use App\Http\Requests\API\ExpenseRequest;

class Expenses extends Controller
{
    public function index()
    {
        return Expense::all();
    }

    public static function totalExpense() : float
    {
        $collection = collect(Expense::all());

        $total = $collection->reduce(function ($acc, $value) {
            return $acc + $value['amount'];
        }, 0);

        return $total;
    }

    public function store(ExpenseRequest $request)
    {   
        // take all the details in the submitted request and store them into a variable.
        $data = $request->all();
        // create and return a new expense with the the variable we created.
        return Expense::create($data);
    }

    // the expense gets passed in for us using Route Model Binding
    public function show(Expense $expense)
    {
        return $expense;
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        // get the request data
        $data = $request->all();

        // update the expense using the fill method
        // then save it to the database
        $expense->fill($data)->save();
        
        // return the updated version
        return $expense;
    }

    public function destroy(Expense $expense)
    {
        // delete the expense from the DB
        $expense->delete();
        
        // use a 204 code as there is no content in the response
        return response(null, 204);
    }
}
