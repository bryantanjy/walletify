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
        $categories = ['C01', 'C02', 'C03', 'C04', 'C05', 'C06', 'C07', 'C08', 'C09', 'C10', 'C11', 'C12', 'C13', 'C14'];

        return [

            
            'user_id' => rand(1, 2),
            'account_id' => rand(1, 2),
            'category_id' => $this->faker->randomElement($categories),
            'group_id' => null,
            'record_type' => $this->faker->randomElement(['Expense', 'Income']),
            'amount' => $this->faker->randomFloat(2, 0, 70),
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'record_description' => $this->faker->sentence(2),
        ];
    }
}
