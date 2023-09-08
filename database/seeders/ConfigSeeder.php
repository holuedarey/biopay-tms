<?php

namespace Database\Seeders;


use App\Models\Config;
use App\Models\Fee;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create(['name' => 'DEFAULT_GROUP_ID', 'value' => 1]);
    }
}
