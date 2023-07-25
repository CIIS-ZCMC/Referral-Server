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
        Schema::create('hospital', function(Blueprint $table){
            $table->id();
            $table->string('mscReferringCenters');
            $table->string('name');
            $table->string('code');
            $table->boolean('isPrivate')->default(0);
            $table->boolean('isGovernment')->default(0);
            $table->unsignedBigInteger('FK_address_ID')->unsigned();
            $table->foreign('FK_address_ID')->references('id')->on('address');
            $table->stirng('local');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('hospital');
    }
};
