<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Category;
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
            'user_id' => User::inRandomOrder()->pluck('id')->first(),
            'account_id' => Account::inRandomOrder()->pluck('id')->first(),
            'category_id' => Category::inRandomOrder()->pluck('id')->first(),
            'expense_sharing_group_id' => null,
            'type' => $this->faker->randomElement(['Expense', 'Income']),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'datetime' => $this->faker->dateTimeThisYear(),
            'description' => $this->faker->sentence(),
        ];
    }
}
