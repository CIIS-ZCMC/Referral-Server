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
        Schema::create('bizzboxadmission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_patient_ID')->unsigned();
            $table->foreign('FK_patient_ID')->references('id')->on('patient');
            $table->unsignedBigInteger('FK_referral_ID')->unsigned();
            $table->foreign('FK_referral_ID')->references('id')->on('referral');
            $table->unsignedBigInteger('Pat_id');
            $table->date('register_date')->default(now());
            $table->text('disch_diagnosis');
            $table->text('final_diagnosis');
            $table->date('disch_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bizzboxadminssion');
    }
};
