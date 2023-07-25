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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_referral_ID')->unsigned();
            $table->foreign('FK_referral_ID')->references('id')->on('referral');
            $table->unsignedBigInteger('FK_referred_from_ID')->unsigned();
            $table->foreign('FK_referred_from_ID')->references('id')->on('hospital');
            $table->unsignedBigInteger('FK_referred_to_ID')->unsigned();
            $table->foreign('FK_referred_to_ID')->references('id')->on('hospital');
            $table->date('date');
            $table->text('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
