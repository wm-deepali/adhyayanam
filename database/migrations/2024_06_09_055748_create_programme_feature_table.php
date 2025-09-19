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
        Schema::create('programme_feature', function (Blueprint $table) {
            $table->id();
            $table->string('banner')->nullable();
            $table->string('title')->nullable();
            $table->string('short_description')->nullable();
            $table->string('heading')->nullable();
            $table->string('feature')->nullable();
            $table->string('icon1')->nullable();
            $table->string('icon2')->nullable();
            $table->string('icon3')->nullable();
            $table->string('icon4')->nullable();
            $table->string('icon_title1')->nullable();
            $table->string('icon_title2')->nullable();
            $table->string('icon_title3')->nullable();
            $table->string('icon_title4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programme_feature');
    }
};
