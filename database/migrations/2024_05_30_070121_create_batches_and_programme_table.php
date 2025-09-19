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
        Schema::create('batches_and_programme', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('duration');
            $table->string('start_date');
            $table->decimal('mrp', 10, 2);
            $table->integer('discount')->default(0);
            $table->decimal('offered_price', 10, 2);
            $table->string('batch_heading');
            $table->text('short_description');
            $table->text('batch_overview');
            $table->text('detail_content');
            $table->string('thumbnail_image');
            $table->string('banner_image');
            $table->string('youtube_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('image_alt_tag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches_and_programme');
    }
};
