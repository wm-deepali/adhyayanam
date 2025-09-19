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
        Schema::create('blog_and_articles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('heading');
            $table->string('short_description')->nullable();
            $table->text('description');
            $table->string('type');
            $table->string('image');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_and_articles');
    }
};
