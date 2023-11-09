<?php

namespace Database\Factories;

use App\Models\Category;
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
            'user_id' => 1,
            'account_id' => $this->faker->numberBetween(2, 6),
            'category_id' => $this->faker->numberBetween(1, 14),
            'group_id' => null,
            'type' => $this->faker->randomElement(['Expense', 'Income']),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'description' => $this->faker->sentence(2),
        ];
    }
}
