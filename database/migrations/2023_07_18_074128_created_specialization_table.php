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
        Schema::create('specialization', function(Blueprint $table){
            $table -> id();
            $table -> string('title');
            $table -> string('description') -> nullable();
            $table -> boolean('status') -> default(1);
            $table -> boolean('deactivated') -> default(0);
            $table -> date('created_at') -> default(now());
            $table -> date('updated_at') -> default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('specialization');
    }
};
