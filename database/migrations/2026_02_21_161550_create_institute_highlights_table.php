<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institute_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('main_heading')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sub_sub_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_highlights');
    }
};
