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
        Schema::create('g_l_t_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->unsignedBigInteger('gl_id')->nullable();
            $table->float('amount', 12)->default(0);
            $table->float('impact_amount')->nullable();
            $table->float('prev_balance', 12)->default(0);
            $table->float('new_balance', 12)->default(0);
            $table->enum('type', \App\Enums\Action::values());
            $table->longText('info')->nullable();
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
        Schema::dropIfExists('g_l_t_s');
    }
};
