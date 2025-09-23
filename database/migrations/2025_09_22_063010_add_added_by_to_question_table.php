<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('question', function (Blueprint $table) {
            // Add polymorphic columns
            $table->unsignedBigInteger('added_by_id')->nullable()->after('id')->comment('ID of the user or teacher who added the question');
            $table->string('added_by_type')->nullable()->after('added_by_id')->comment('Type: User or Teacher');
        });
    }

    public function down(): void
    {
        Schema::table('question', function (Blueprint $table) {
            $table->dropColumn(['added_by_id', 'added_by_type']);
        });
    }
};
