<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::role(Role::AGENT)->inRandomOrder()->limit(3)->each(
            fn($user) => Loan::factory(4)->create([
                'user_id' => $user->id
            ])
        );
    }
}
