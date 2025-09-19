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
        Schema::create('direct_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('query_for');
            $table->string('full_name');
            $table->string('mobile');
            $table->string('email');
            $table->text('details');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direct_enquiries');
    }
};
