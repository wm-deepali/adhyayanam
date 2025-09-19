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
        Schema::create('upcoming_exam', function (Blueprint $table) {
            $table->id();
            $table->integer('commission_id');
            $table->string('examination_name');
            $table->date('advertisement_date');
            $table->date('form_distribution_date');
            $table->date('submission_last_date');
            $table->date('examination_date');
            $table->string('link')->nullable();
            $table->string('pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upcoming_exam');
    }
};
