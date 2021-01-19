<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Income;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Income::class, function (Faker $faker) {

    $categories = ['paycheck', 'gift', 'other'];
    $randomCategory = $categories[array_rand($categories)];

    return [
        'amount' => number_format(mt_rand(1, 1000) / 10, 2),
        'category' => $randomCategory,
    ];
});
