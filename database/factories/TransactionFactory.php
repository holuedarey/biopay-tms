<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Helpers\RoleHelper;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $s = Service::regular()->pluck('id')->toArray();
        $t = Terminal::all()->pluck('id')->toArray();

        $amount = fake()->randomNumber(5);
        $charge = (1.5 / 100) * $amount;
        $total = $amount + $charge;

        return [
            'type_id'   => Arr::random($s),
            'terminal_id' => $id = Arr::random($t),
            'user_id' => Terminal::find($id)->user_id,
            'amount'    => $amount,
            'charge'    => $charge,
            'total_amount' => $total,
            'reference' => Str::random(),
            'status'    => Arr::random([Status::SUCCESSFUL, Status::FAILED]),
            'info'      => 'Seeded',
            'created_at' => fake()->dateTimeBetween('- 3 weeks')
        ];
    }
}
