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
        Schema::create('cancelled_referral', function (Blueprint $table) {
            $table->id();
            $table->text('remarks');
            $table->unsignedBigInteger('FK_referral_ID')->unsigned();
            $table->foreign('FK_referral_ID')->referrences('id')->on('referrals');
            $table->date('date')->default(now());
            $table->integer('prevStatus');
            $table->boolean('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_referral');
    }
};
