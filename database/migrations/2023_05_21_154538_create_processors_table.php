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
        Schema::create('processors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            $table->unsignedInteger('port');
            $table->boolean('ssl')->default(true);
            $table->string('comp1'); // Component key 1
            $table->string('comp2'); // Component key 2
            $table->string('zpk')->nullable(); // Zone Pin key
            $table->boolean('requiresKey')->default(false);
            $table->string('tid_prefix')->nullable();
            $table->string('mid_prefix')->nullable();
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
        Schema::dropIfExists('processors');
    }
};
