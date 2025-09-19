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
        Schema::create('current_affairs', function (Blueprint $table) {
            $table->id();
            $table->integer('topic_id');
            $table->string('title');
            $table->string('short_description');
            $table->longText('details')->nullable();
            $table->date('publishing_date');
            $table->string('thumbnail_image');
            $table->string('banner_image')->nullable();
            $table->string('image_alt_tag')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_affairs');
    }
};
