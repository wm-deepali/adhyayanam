<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 10, 2);
            $table->string('source'); // MCQ / Subjective / Story
            $table->text('details')->nullable(); // question IDs or extra info
            $table->timestamps();

            // Only index on created_at for now, to avoid length issue
            $table->index('created_at');
        });

        // Add index with prefix length for 'source' after table created
        DB::statement('CREATE INDEX wallet_transactions_teacher_id_source_index ON wallet_transactions (teacher_id, source(50))');
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
