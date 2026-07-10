<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('mode', ['manual', 'auto'])->default('manual');
            $table->string('frequency')->nullable(); // daily, weekly, monthly (only used if mode = auto)
            $table->time('run_time')->nullable();     // e.g. 02:00:00 for 2 AM auto backups
            $table->unsignedInteger('keep_last')->default(7); // kitne purane backups Drive par rakhne hain
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_settings');
    }
};