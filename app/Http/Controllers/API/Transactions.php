<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Requests\API\TransactionRequest;
use App\Http\Resources\API\TransactionResource;
use App\Http\Resources\API\TransactionsByDateRangeResource;
use App\Utility\ConvertCurrency;
use Carbon\Carbon;


class Transactions extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

    public function store(TransactionRequest $request)
    {   
        // take all the details in the submitted request and store them into a variable.
        $data = $request->all();

        // create and return a new Transaction with the the variable we created.
        $transaction = Transaction::create($data);
        return new TransactionResource($transaction);
    }

    // the Transaction gets passed in for us using Route Model Binding
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        // get the request data
        $data = $request->all();

        // update the Transaction using the fill method
        // then save it to the database
        $transaction->fill($data)->save();
        
        // return the updated version
        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        // delete the Transaction from the DB
        $transaction->delete();
        
        // return a message that could displayed on the front end as feedback later on
        return response()->json([
            "message" => "Transaction deleted successfully",
        ]);
    }

    public function showTransactionsByDateRange(Request $request)
    {
        $rate = ConvertCurrency::getConversionRate($request->currency);

        // add one day to make 'to' value included in the queried transactions 
        $to = new Carbon($request->get('to'));
        $toPlusOneDay = $to->addDays(1);
        $transactions = Transaction::where("user_id", $request->user_id)
            ->whereBetween('created_at', [$request->get('from'), $toPlusOneDay])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            "currency" => $request->currency,
            "rate" => $rate,
            "user_id" => $request->user_id
        ];

        return new TransactionsByDateRangeResource($transactions, $data);
    }
}
