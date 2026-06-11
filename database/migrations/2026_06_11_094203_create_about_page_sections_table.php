<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_page_sections', function (Blueprint $table) {
            $table->id();

            $table->string('section_key')->unique();

            $table->string('sub_title')->nullable();
            $table->string('heading')->nullable();

            $table->longText('description')->nullable();

            $table->string('image')->nullable();

            $table->json('extra_data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page_sections');
    }
};