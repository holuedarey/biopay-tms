<?php

namespace Database\Seeders;


use App\Http\Controllers\Approvals;
use App\Models\TerminalGroup;
use Illuminate\Database\Seeder;

class TerminalGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new TerminalGroup(['name' => 'DEFAULT', 'info' => 'Default terminal groups']))->withoutApproval()->save();
    }
}
