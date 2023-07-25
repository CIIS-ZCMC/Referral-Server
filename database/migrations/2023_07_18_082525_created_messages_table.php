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
        Schema::create('messages',function(Blueprint $table){
            $table->id();
            $table->text('content')->nullable();
            $table->date('date')->default(now());
            $table->unsignedBigInteger('FK_referral_ID')->unsigned();
            $table->foreign('FK_referral_ID')->references('id')->on('referral');
            $table->unsignedBigInteger('FK_user_ID')->unsigned();
            $table->foreign('FK_user_ID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('messages');
    }
};
