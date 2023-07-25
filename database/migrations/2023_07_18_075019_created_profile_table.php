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
        Schema::create('profile', function(Blueprint $table){
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('ext_name')->nullable();
            $table->date('bod');
            $table->string('sex');
            $table->string('contact')->nullable();
            $table->unsignedBigInteger('FK_user_ID')->unsigned();
            $table->foreign('FK_user_ID')->references('id')->on('users');
            $table->unsignedBigInteger('FK_hospital_ID')->unsigned();
            $table->foreign('FK_hospital_ID')->references('id')->on('hospital');
            $table->unsignedBigInteger('FK_department_ID')->unsigned()->nullable();
            $table->foreign('FK_department_ID')->references('id')->on('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('profile');
    }
};
