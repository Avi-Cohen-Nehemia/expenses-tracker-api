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
                'category' => 'Shopping',
            ],
            [
                'amount' => 21.85,
                'category' => 'Food',
            ],
            [
                'amount' => 128.00,
                'category' => 'Bills',
            ],
        ]);
    }
}
