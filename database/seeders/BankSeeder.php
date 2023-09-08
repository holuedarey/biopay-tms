<?php

namespace Database\Seeders;

use App\Repository\Spout;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new Spout)->updateBankList();
    }
}
