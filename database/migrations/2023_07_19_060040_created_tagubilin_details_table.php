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
        Schema::create('tagubulindetails', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('address');
            $table->string('ward');
            $table->string('hrn');
            $table->date('admission_date');
            $table->date('disch_date');
            $table->text('disch_diagnosis');
            $table->string('operation');
            $table->string('surgeon');
            $table->date('operation_date');
            $table->string('health');
            $table->string('health_others');
            $table->string('instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagubulindetails');
    }
};
