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
        Schema::create('syllabus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('title');
             $table->string('type');
            $table->string('pdf')->nullable(); // PDF file path
            $table->longText('detail_content')->nullable(); // CKEditor content
            $table->boolean('status')->default(1);
            $table->timestamps();

            // Optional: Add foreign key relationships if these tables exist
            $table->foreign('commission_id')->references('id')->on('examination_commission')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabus');
    }
};
