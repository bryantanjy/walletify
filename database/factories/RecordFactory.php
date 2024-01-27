<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Category;
use App\Models\ExpenseSharingGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 2,
            'account_id' => 5,
            'category_id' => Category::inRandomOrder()->pluck('id')->first(),
            'expense_sharing_group_id' => null,
            'type' => $this->faker->randomElement(['Expense', 'Income']),
            'amount' => $this->faker->randomFloat(2, 1, 50),
            'datetime' => $this->faker->dateTimeBetween('-1 year first day of October', 'now')->format('Y-m-d H:i:s'),
            'description' => null,
        ];
    }
}
