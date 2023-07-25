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
        Schema::create('result',function(Blueprint $table){
            $table->id();
            $table->string('laboratory');
            $table->string('x-ray');
            $table->string('ct-scan');
            $table->string('mri');
            $table->string('other')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('result');
    }
};
