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
        Schema::create('test_series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('category');
            $table->integer('total_chapter')->default(0);
            $table->integer('total_affairs')->default(0);
            $table->integer('free_tests')->default(0);
            $table->integer('total_subjects')->default(0);
            $table->integer('users_count')->default(0);
            $table->string('logo')->nullable();
            $table->integer('total_marks')->default(0);
            $table->integer('duration'); // Assuming duration is in minutes
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_series');
    }
};
