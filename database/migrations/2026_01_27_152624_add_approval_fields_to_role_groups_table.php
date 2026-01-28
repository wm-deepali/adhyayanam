<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('role_groups', function (Blueprint $table) {

            // approval workflow status
            $table->enum('status', [
                'draft',
                'pending_approval',
                'approved',
                'published'
            ])->default('draft')->after('permissions');

            // who approved (admin)
            $table->unsignedBigInteger('approved_by')->nullable()->after('created_by');

            // foreign keys (optional but recommended)
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('approved_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('role_groups', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'status',
                'approved_by'
            ]);
        });
    }
};