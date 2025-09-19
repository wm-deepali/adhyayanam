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
        Schema::create('study_material', function (Blueprint $table) {
            $table->id();
            $table->integer('commission_id');
            $table->integer('category_id');
            $table->string('topic');
            $table->string('short_description');
            $table->longText('detail_content');
            $table->integer('status')->default(0);
            $table->string('pdf')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_material');
    }
};
