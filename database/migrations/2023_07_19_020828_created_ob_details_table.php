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
        Schema::create('obdetails', function (Blueprint $table) {
            $table->id();
            $table->string('gp');
            $table->string('lmp');
            $table->string('aog');
            $table->string('edc');
            $table->string('fht');
            $table->string('fh');
            $table->string('apgar');
            $table->string('le');
            $table->string('bow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obdetails');
    }
};
