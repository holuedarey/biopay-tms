<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terminal_processors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("serial");
            $table->string("processor_id");
            $table->string("processor_name");
            $table->string("tid");
            $table->string("mid");
            $table->string('tmk')->nullable();
            $table->string('tpk')->nullable();
            $table->string('tsk')->nullable();
            $table->string('currency_code', 3)->default('566');
            $table->string('country_code', 3)->default('566');
            $table->string('category_code', 4)->nullable();
            $table->string('name_location', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminal_processors');
    }
};
