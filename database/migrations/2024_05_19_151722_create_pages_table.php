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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('heading1')->nullable(); // Adding the heading column
            $table->string('heading2')->nullable();
            $table->text('description1')->nullable(); // Adding the description column
            $table->text('description2')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
