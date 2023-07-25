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
        Schema::create('covid',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('FK_user_ID')->unsigned();
            $table->foreign('FK_user_ID')->references('id')->on('users');
            $table->unsignedBigInteger('FK_patient_ID')->unsigned();
            $table->foreign('FK_patient_ID')->references('id')->on('patient');
            $table->string('swab_type');
            $table->boolean('result')->default(0);
            $table->date('swab_date')->default(now());
            $table->date('result_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('covid');
    }
};
