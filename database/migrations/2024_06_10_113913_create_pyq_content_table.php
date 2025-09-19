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
        Schema::create('pyq_content', function (Blueprint $table) {
            $table->id();
            $table->string('commission_id');
            $table->string('category_id');
            $table->string('sub_category_id');
            $table->text('heading');
            $table->longText('detail_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pyq_content');
    }
};
