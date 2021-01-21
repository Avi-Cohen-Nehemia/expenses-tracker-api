<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {

    $allCategories = ['groceries', 'shopping', 'rent', 'bills', 'entertainment', 'fuel', 'takeaway', 'paycheck', 'gift', 'other', 'paycheck', 'gift', 'other'];

    $expenseCategories = ['groceries', 'shopping', 'rent', 'bills', 'entertainment', 'fuel', 'takeaway', 'paycheck', 'gift', 'other'];
    $incomeCategories = ['paycheck', 'gift', 'other'];

    $randomCategory = $allCategories[array_rand($allCategories)];
    $type = in_array($randomCategory , $incomeCategories, true );

    return [
        'amount' => number_format(mt_rand(1, 1000) / 10, 2),
        'category' => $randomCategory,
        'type' => $type ? 'income' : 'expense',
    ];
});
