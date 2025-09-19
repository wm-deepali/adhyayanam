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
        Schema::create('daily_booster', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_url');
            $table->string('short_description');
            $table->longText('detail_content');
            $table->string('thumbnail');
            $table->string('image_alt_tag')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_booster');
    }
};
