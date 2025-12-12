<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('percentage_system', function (Blueprint $table) {
            $table->id();
            $table->decimal('from_percentage', 5, 2);
            $table->decimal('to_percentage', 5, 2);
            $table->string('division');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('percentage_system');
    }
};
