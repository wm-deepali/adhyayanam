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
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('examination_commission_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('name');
            $table->string('duration');
            $table->decimal('course_fee', 10, 2);
            $table->integer('discount')->default(0);
            $table->decimal('offered_price', 10, 2);
            $table->integer('num_classes');
            $table->integer('num_topics');
            $table->string('language_of_teaching');
            $table->string('course_heading');
            $table->text('short_description');
            $table->text('course_overview');
            $table->text('detail_content');
            $table->string('thumbnail_image');
            $table->string('banner_image');
            $table->string('youtube_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('image_alt_tag')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('examination_commission_id')->references('id')->on('examination_commission')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
