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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_referral_ID')->unsigned();
            $table->foreign('FK_referral_ID')->references('id')->on('referral');
            $table->unsignedBigInteger('FK_referral_status_ID')->unsigned();
            $table->foreign('FK_referral_status_ID')->references('id')->on('referral_status');
            $table->string('description')->nullable();
            $table->date('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
