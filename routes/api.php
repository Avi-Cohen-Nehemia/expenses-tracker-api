<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Transactions;
use App\Http\Controllers\API\Users;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// get all transactions
Route::get("/transactions", [Transactions::class, "index"]);

// get balance
Route::get("/transactions/balance", [Transactions::class, "getBalance"]);

// create a new transaction
Route::post("/transactions/create", [Transactions::class, "store"]);

// show a specific transaction
Route::get("/transactions/{transaction}", [Transactions::class, "show"]);

// update a specific transaction
Route::put("/transactions/{transaction}", [Transactions::class, "update"]);

// delete a specific transaction
Route::delete("/transactions/{transaction}", [Transactions::class, "destroy"]);



// get all users
Route::get("/users", [Users::class, "index"]);

// show a specific user
Route::get("/users/{user}", [Users::class, "show"]);

// create a new user
Route::post("/users/create", [Users::class, "store"]);

// create a new user
Route::delete("/users/{user}", [Users::class, "destroy"]);
