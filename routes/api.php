<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Expenses;

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

// get all expenses
Route::get("/expenses", [Expenses::class, "index"]);

// create a new expense
Route::post("/expenses", [Expenses::class, "store"]);

// show a specific expense
Route::get("/expenses/{expense}", [Expenses::class, "show"]);

// update a specific expense
Route::put("/expenses/{expense}", [Expenses::class, "update"]);

// delete a specific expense
Route::delete("/expenses/{expense}", [Expenses::class, "destroy"]);


// get all incomes
Route::get("/incomes", [Incomes::class, "index"]);

// create a new income
Route::post("/incomes", [Incomes::class, "store"]);

// show a specific income
Route::get("/incomes/{income}", [Incomes::class, "show"]);

// update a specific income
Route::put("/incomes/{income}", [Incomes::class, "update"]);

// delete a specific income
Route::delete("/incomes/{income}", [Incomes::class, "destroy"]);