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
        Schema::create('amount_configs', function (Blueprint $table) {
            $table->id();
            $table->float('min_amount', 12);
            $table->float('max_amount', 12);
            $table->string('primary');
            $table->unsignedBigInteger('primary_id');
            $table->string('secondary');
            $table->unsignedBigInteger('secondary_id');
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
        Schema::dropIfExists('amount_configs');
    }
};
