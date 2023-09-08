<?php

namespace Database\Seeders;

use App\Models\AmountConfig;
use App\Models\CardConfig;
use App\Models\Processor;
use App\Models\RoutingType;
use Illuminate\Database\Seeder;

class RoutingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // processors
        (new Processor([
            'name' => 'INTERSWITCH', 'host' => '167.71.6.36', 'port' => '8081', 'ssl' => false,
            'comp1' => '11111111111111111111111111111111', 'comp2' => '11111111111111111111111111111111',
            'tid_prefix' => '2DP', 'mid_prefix' => '2DP'
        ]))->withoutApproval()->save();

        (new Processor([
            'name' => '3LINE', 'host' => '108.129.63.76', 'port' => '8080', 'ssl' => false,
            'comp1' => '619C213428CFC2F1F0EB820478073A7F', 'comp2' => '619C213428CFC2F1F0EB820478073A7F'
        ]))->withoutApproval()->save();


        // Routing config
        (new RoutingType(['name' => 'AMOUNT', 'active' => true]))->withoutApproval()->save();
        (new RoutingType(['name' => 'CARD']))->withoutApproval()->save();
//        RoutingType::create(['name' => 'PRIORITY']);


        // Amount config
        (new AmountConfig([
            'min_amount' => 1, 'max_amount' => 4000,
            'primary' => '3LINE', 'primary_id' => 2, 'secondary' => 'INTERSWITCH', 'secondary_id' => 1
        ]))->withoutApproval()->save();
        (new AmountConfig([
            'min_amount' => 4001, 'max_amount' => 2000000,
            'primary' => 'INTERSWITCH', 'primary_id' => 1, 'secondary' => '3LINE', 'secondary_id' => 2
        ]))->withoutApproval()->save();


        // Card Config
        (new CardConfig([
            'card_type' => 'MASTERCARD', 'primary' => '3LINE', 'primary_id' => 2, 'secondary' => 'INTERSWITCH', 'secondary_id' => 1
        ]))->withoutApproval()->save();

        (new CardConfig([
                'card_type' => 'VISA', 'primary' => 'INTERSWITCH', 'primary_id' => 1, 'secondary' => '3LINE', 'secondary_id' => 2
        ]))->withoutApproval()->save();

        (new CardConfig([
            'card_type' => 'VERVE', 'primary' => 'INTERSWITCH', 'primary_id' => 1, 'secondary' => '3LINE', 'secondary_id' => 2
        ]))->withoutApproval()->save();

        (new CardConfig([
            'card_type' => 'OTHERS', 'primary' => 'INTERSWITCH', 'primary_id' => 1, 'secondary' => '3LINE', 'secondary_id' => 2
        ]))->withoutApproval()->save();
    }
}
