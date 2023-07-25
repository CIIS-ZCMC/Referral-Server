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
        Schema::create('admitting', function (Blueprint $table) {
            $table->id();
            $table->date('admitted')->nullable();
            $table->string('type');
            $table->string('disposition');
            $table->unsignedBigInteger('FK_specialization_ID')->unsigned();
            $table->foreign('FK_specialization_ID')->references('id')->on('specializaiton');
            $table->integer('temperature')->nullable();
            $table->integer('blood_pressure')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('oxygen')->nullable();
            $table->integer('o2_sat')->nullable();
            $table->integer('gcs')->nullable();
            $table->text('chief_complaints')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('endorsement')->nullable();
            $table->text('referring_ROD')->nullable();
            $table->text('reason');
            $table->text('patient_history');
            $table->text('pertinent_pe')->nullable();
            $table->string('lvf');
            $table->string('labs');
            $table->string('meds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admitting');
    }
};
