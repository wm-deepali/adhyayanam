<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_page_highlights', function (Blueprint $table) {
            $table->id();

            $table->string('icon')->nullable();
            $table->string('heading');
            $table->text('short_description')->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page_highlights');
    }
};