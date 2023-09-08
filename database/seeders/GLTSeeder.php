<?php

namespace Database\Seeders;

use App\Models\GeneralLedger;
use App\Models\GLT;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GLTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gls = GeneralLedger::all();

        $gls->each(fn($item) => GLT::factory(rand(20, 30))->create([ 'gl_id' => $item->id ]));
    }
}
