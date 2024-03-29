<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create(table: 'approvals', callback: function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("performed_by")->nullable();
            $table->nullableMorphs(config(key: 'approval.approval.approval_pivot'));
            $table->enum('state', ['pending', 'approved', 'rejected'])->default('pending');
            $table->jsonb('new_data')->nullable();
            $table->jsonb('original_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(table: 'approvals');
    }
};
