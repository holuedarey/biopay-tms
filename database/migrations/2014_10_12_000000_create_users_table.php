<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('level_id')->nullable();
            $table->unsignedBigInteger('super_agent_id')->nullable();
            $table->string('first_name');
            $table->string('other_names');
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable()->unique();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('dob')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->mediumText('address')->nullable();
            $table->enum('status', \App\Models\User::ALL_STATUS)->default('INACTIVE');
            $table->string('avatar')->nullable();
            $table->string('bvn', 11)->nullable()->unique();
            $table->string('nin', 15)->nullable()->unique();
            $table->timestamp('password_change_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
