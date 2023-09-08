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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id')->default(1);
            $table->string('device');
            $table->string('serial');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('INACTIVE');
            $table->string('tid', 8)->unique();
            $table->string('mid', 15)->nullable();
            $table->string('tmk', 38)->nullable();
            $table->string('tsk', 38)->nullable();
            $table->string('tpk', 38)->nullable();
            $table->string('date_time', 14)->nullable();
            $table->smallInteger('timeout')->default(60);
            $table->string('currency_code', 3)->default('566');
            $table->string('country_code', 3)->default('566');
            $table->string('category_code', 4)->nullable();
            $table->string('name_location', 40)->nullable();
            $table->string('admin_pin')->default('0000');
            $table->string('pin')->default('0000');
            $table->integer('wrong_pin_count')->default(0);
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
        Schema::dropIfExists('terminals');
    }
};
