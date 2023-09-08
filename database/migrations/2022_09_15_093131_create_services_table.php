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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('provider_id')->nullable();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('menu_name')->nullable();
            $table->boolean('is_available')->default(true);
            $table->mediumText('description')->nullable();
            $table->boolean('menu')->default(true);
            $table->boolean('internal')->default(false);
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
        Schema::dropIfExists('services');
    }
};
