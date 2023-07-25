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
        Schema::create('tagubulin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_tagubilin_details_ID')->unsigned();
            $table->foreign('FK_tagubilin_details_ID')->references('id')->on('tagubilin_details');
            $table->unsignedBigInteger('FK_result_ID')->unsigned();
            $table->foreign('FK_result_ID')->references('id')->on('result');
            $table->unsignedBigInteger('FK_medication_ID')->unsigned();
            $table->foreign('FK_medication_ID')->references('id')->on('medication');
            $table->unsignedBigInteger('FK_breastfeed_ID')->unsigned();
            $table->foreign('FK_breastfeed_ID')->references('id')->on("breastfeed");
            $table->unsignedBigInteger('FK_follow_up_ID')->unsigned();
            $table->foreign('FK_follow_up_ID')->references('id')->on('followup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagubulin');
    }
};
