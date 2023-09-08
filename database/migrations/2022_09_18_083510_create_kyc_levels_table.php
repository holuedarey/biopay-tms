<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kyc_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->float('daily_limit', 12);
            $table->float('single_trans_max', 12);
            $table->float('max_balance', 12);
            $table->integer('no_of_agents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kyc_levels');
    }
};
