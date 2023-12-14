<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
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
            'type' => $this->faker->randomElement(['General', 'Saving Account', 'Cards', 'Cash', 'Insurance', 'Loan', 'Investment']),
            'name' => $this->faker->word(),
        ];
    }
}
