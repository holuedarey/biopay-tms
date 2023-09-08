<?php

namespace Database\Factories;

use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Terminal>
 */
class TerminalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'device'        => fake()->word(),
            'status'        => ['ACTIVE', 'INACTIVE'][rand(0,1)],
            'tid'           => Str::random(8),
            'mid'           => Str::random(15),
            'serial'        => Str::random(20),
            'tmk'           => Str::random(38),
            'tsk'           => Str::random(38),
            'tpk'           => Str::random(38),
            'category_code' => '1234',
            'date_time'     => fake()->dateTime()->format('d/m/y H:i'),
            'name_location' => Str::random(40),
        ];
    }
}
