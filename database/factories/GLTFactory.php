<?php

namespace Database\Factories;

use App\Enums\Action;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GLT>
 */
class GLTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type'      => Action::values()[rand(0,1)],
            'info'      => 'seeded',
            'amount'    => fake()->randomNumber(5),
            'prev_balance'  => fake()->randomNumber(5),
            'new_balance'   => fake()->randomNumber(6)
        ];
    }
}
