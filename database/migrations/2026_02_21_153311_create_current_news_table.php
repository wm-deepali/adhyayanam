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
        Schema::create('current_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->enum('type', ['pdf', 'link', 'page']);

            $table->text('short_description')->nullable();
            $table->longText('detail_content')->nullable();

            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('url')->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_news');
    }
};
