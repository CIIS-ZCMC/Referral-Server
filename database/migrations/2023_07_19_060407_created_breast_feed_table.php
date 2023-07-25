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
        Schema::create('breastfeed', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('from_to');
            $table->boolean('yes');
            $table->string('reason_for_no');
            $table->string('management');
            $table->string('attended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breastfeed');
    }
};
