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
        Schema::create('followup', function (Blueprint $table) {
            $table->id();
            $table->date('follow_up_date');
            $table->string('follow_up_time');
            $table->string('need_to_bring');
            $table->string('nurse');
            $table->string('resident');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup');
    }
};
