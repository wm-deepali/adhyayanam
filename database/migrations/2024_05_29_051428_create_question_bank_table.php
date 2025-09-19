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
        Schema::create('question_bank', function (Blueprint $table) {
            $table->id();
            $table->integer('language');
            $table->integer('question_type');
            $table->year('previous_year')->nullable();
            $table->unsignedBigInteger('commission_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unsignedBigInteger('topic');
            $table->boolean('has_instruction')->default(false);
            $table->text('instruction')->nullable();
            $table->boolean('has_option_e')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_bank');
    }
};
