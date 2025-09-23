<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Extra fields
            $table->date('payment_date')->nullable();
            $table->string('reference_id')->nullable();
            $table->text('remarks')->nullable();
            $table->string('screenshot')->nullable(); // store file path
            $table->unsignedBigInteger('processed_by')->nullable(); // admin id who processed

            $table->timestamps();

            $table->foreign('teacher_id')
                  ->references('id')
                  ->on('teachers')
                  ->onDelete('cascade');
            // Optional: foreign key if you have an admins table
            // $table->foreign('processed_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
