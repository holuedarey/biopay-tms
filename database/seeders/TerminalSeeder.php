<?php

namespace Database\Seeders;

use App\Helpers\RoleHelper;
use App\Models\Role;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agents = User::role(Role::AGENT)->get();

        $agents->each(function (User $agent) {

            (
                new Terminal([
                'user_id' => $agent->id,
                'group_id' => 1,
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
            ]))->withoutApproval()->save();
        });
    }
}
