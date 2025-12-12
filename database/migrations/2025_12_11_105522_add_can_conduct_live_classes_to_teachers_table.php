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
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'can_conduct_live_classes')) {
                $table->boolean('can_conduct_live_classes')
                      ->default(0)
                      ->after('total_experience'); // or any column you prefer
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'can_conduct_live_classes')) {
                $table->dropColumn('can_conduct_live_classes');
            }
        });
    }
};
