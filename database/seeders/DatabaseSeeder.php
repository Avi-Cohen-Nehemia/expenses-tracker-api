<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        User::newFactory()->count(1)->create();
        Transaction::newFactory()->count(10)->create();
    }
}
