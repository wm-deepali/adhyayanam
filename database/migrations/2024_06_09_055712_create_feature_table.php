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
        Schema::create('feature', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('icon1')->nullable();
            $table->string('icon2')->nullable();
            $table->string('icon3')->nullable();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('title3')->nullable();
            $table->string('short_description1')->nullable();
            $table->string('short_description2')->nullable();
            $table->string('short_description3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature');
    }
};
