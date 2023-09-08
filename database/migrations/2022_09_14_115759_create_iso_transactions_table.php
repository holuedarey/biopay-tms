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
        Schema::create('iso_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('reference')->unique();
            $table->string('provider');
            $table->string('serial');
            $table->double('amount', 12, 2);
            $table->double('charge', 12, 2);
            $table->double('total_amount', 12, 2);
            $table->string('customer_name')->nullable();
            $table->string('card_type')->nullable();
            $table->string('device')->nullable();
            $table->string('version')->nullable();
            $table->string('f2', 19);
            $table->string('f3', 6);
            $table->string('f4', 12);
            $table->string('f5', 12)->nullable();
            $table->string('f7', 10);
            $table->string('f9', 8)->nullable();
            $table->string('f11', 6);
            $table->string('f12', 6);
            $table->string('f13', 4);
            $table->string('f14', 4);
            $table->string('f15', 4);
            $table->string('f16', 4)->nullable();
            $table->string('f18', 4);
            $table->string('f22', 3)->nullable();
            $table->string('f23', 3);
            $table->string('f25', 2)->default('00');
            $table->string('f26', 2)->default('04');
            $table->string('f28', 9);
            $table->string('f30', 9)->nullable();
            $table->string('f31', 9)->nullable();
            $table->string('f32', 11)->nullable();
            $table->string('f33', 11)->nullable();
            $table->string('f35', 37);
            $table->string('f37', 12);
            $table->string('f38', 6)->nullable();
            $table->string('f39', 2)->nullable();
            $table->string('f40', 3);
            $table->string('f41', 8);
            $table->string('f42', 15);
            $table->string('f43', 40);
            $table->string('f44', 25)->nullable();
            $table->string('f45', 76)->nullable();
            $table->longText('f48')->nullable();
            $table->string('f49', 3);
            $table->string('f50', 3)->nullable();
            $table->string('f52', 3)->nullable();
            $table->string('f53', 96)->nullable();
            $table->string('f54', 120)->nullable();
            $table->longText('f55')->nullable();
            $table->string('f56', 4);
            $table->string('f58', 11)->nullable();
            $table->longText('f59')->nullable();
            $table->string('f98', 25)->nullable();
            $table->string('f100', 11)->nullable();
            $table->string('f102', 28)->nullable();
            $table->string('f103', 28)->nullable();
            $table->string('f123', 15)->nullable();
            $table->timestamps();


            $table->unique(['f4', 'f11', 'f13', 'f37', 'f41'], 'unique_trans_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_transactions');
    }
};
