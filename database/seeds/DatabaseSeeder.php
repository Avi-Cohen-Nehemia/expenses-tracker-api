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
        factory(App\Income::class, 10)->create();

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
