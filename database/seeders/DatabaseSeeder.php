<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // create default configs

        $this->call([
            ConfigSeeder::class,
            RoleSeeder::class,
            RoutingSeeder::class,
            KycLevelSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            TerminalGroupSeeder::class,
            FeeSeeder::class,
            GeneralLedgerSeeder::class,
            /*GLTSeeder::class,
            TerminalSeeder::class,
            TransactionSeeder::class,*/
        ]);
    }
}
