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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_patient_ID')->unsigned();
            $table->foreign('FK_patient_ID')->references('id')->on('patient');
            $table->unsignedBigInteger('FK_ob_case_ID')->unsigned();
            $table->foreign('FK_ob_case_ID')->references('id')->on('obcase');
            $table->unsignedBigInteger('FK_watcher_ID')->unsigned();
            $table->foreign('FK_watcher_ID')->references('id')->on('watcher');
            $table->unsignedBigInteger('FK_admitting_details_ID')->unsigned();
            $table->foreign('FK_admitting_details_ID')->references('id')->on('admitting');
            $table->unsignedBigInteger('FK_hospital_ID')->unsigned();
            $table->foreign('FK_hospital_ID')->references('id')->on('hospital');
            $table->unsignedBigInteger('FK_referral_status_ID')->unsigned();
            $table->foreign('FK_referral_status_ID')->references('id')->on('referral_status');
            $table->boolean('request_edit')->default(0);
            $table->date('request_date')->default(now());
            $table->date('updated_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
