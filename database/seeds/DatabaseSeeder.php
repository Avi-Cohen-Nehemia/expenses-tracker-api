<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expenses')->insert([
            [
                'amount' => 15.50,
                'category' => 'shopping',
            ],
            [
                'amount' => 21.85,
                'category' => 'groceries',
            ],
            [
                'amount' => 128.00,
                'category' => 'bills',
            ],
        ]);

        DB::table('incomes')->insert([
            [
                'amount' => 30.30,
                'category' => 'other',
            ],
            [
                'amount' => 1250.00,
                'category' => 'paycheck',
            ],
            [
                'amount' => 20.00,
                'category' => 'gift',
            ],
        ]);
    }
}
