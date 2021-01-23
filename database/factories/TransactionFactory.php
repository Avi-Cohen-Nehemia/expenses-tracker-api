<?php

namespace Database\Factories;

use App\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $allCategories = ['groceries', 'shopping', 'rent', 'bills', 'entertainment', 'fuel', 'takeaway', 'paycheck', 'gift', 'other', 'paycheck', 'gift', 'other'];

        $expenseCategories = ['groceries', 'shopping', 'rent', 'bills', 'entertainment', 'fuel', 'takeaway', 'paycheck', 'gift', 'other'];
        $incomeCategories = ['paycheck', 'gift', 'other'];

        $randomCategory = $allCategories[array_rand($allCategories)];
        $type = in_array($randomCategory , $incomeCategories, true );

        return [
            'amount' => number_format(mt_rand(1, 1000) / 10, 2),
            'category' => $randomCategory,
            'type' => $type ? 'income' : 'expense',
            'user_id' => 1
        ];
    }
}
