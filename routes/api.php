<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Transactions;
use App\Http\Controllers\API\Users;
use App\Http\Controllers\API\Login;

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

// log in existing user
Route::post("/login", [Login::class, "login"]);

// create a new user
Route::post("/users", [Users::class, "store"]);

Route::group(

    [
        "prefix" => "users",
        "middleware" => ["auth:api"]
    ],
    
    function() {

    // get all users
    Route::get("", [Users::class, "index"]);

    // show a specific user
    Route::get("/{user}", [Users::class, "show"]);

    // create a new user
    Route::delete("/{user}", [Users::class, "destroy"]);
});

Route::group(

    [
        "prefix" => "transactions",
        "middleware" => ["auth:api"]
    ],
    
    function() {

    // get all transactions
    Route::get("", [Transactions::class, "index"]);

    // show a specific transaction
    Route::get("/{transaction}", [Transactions::class, "show"]);

    // create a new transaction
    Route::post("", [Transactions::class, "store"]);

    // update a specific transaction
    Route::put("/{transaction}", [Transactions::class, "update"]);

    // delete a specific transaction
    Route::delete("/{transaction}", [Transactions::class, "destroy"]);
});
