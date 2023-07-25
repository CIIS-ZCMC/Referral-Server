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
        Schema::create('patient', function(Blueprint $table){
            $table->id();
            $table->string('first_name');
            $table->string('middle_name') -> nullable();
            $table->string('last_name');
            $table->string('ext_name')->nullable();
            $table->string('gender');
            $table->date('birthdate');
            $table->string('civil_status');
            $table->string('nationality');
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->unsignedBigInteger('FK_address_ID')->unsigned();
            $table->foreign('FK_address_ID')->references('id')->on('address');
            $table->string('philhealth_no')->nullable();
            $table->boolean('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('patient');
    }
};
