<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // 🔹 Personal Profile
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('mobile_number')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('total_experience')->nullable();
            $table->text('full_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->json('allow_languages')->nullable(); // [Hindi, English]
            $table->string('password')->nullable();

            // 🔹 Question Type Permissions
            $table->boolean('allow_mcq')->default(false);
            $table->decimal('pay_per_mcq', 10, 2)->nullable();
            $table->boolean('allow_subjective')->default(false);
            $table->decimal('pay_per_subjective', 10, 2)->nullable();
            $table->boolean('allow_story')->default(false);
            $table->decimal('pay_per_story', 10, 2)->nullable();

            // 🔹 Bank Details
            $table->string('upi_id')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('cancelled_cheque')->nullable();
            $table->string('qr_code')->nullable();

            // 🔹 Documents
            $table->string('pan_number')->nullable();
            $table->string('pan_file')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('aadhar_front')->nullable();
            $table->string('aadhar_back')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('education_docs')->nullable();
            $table->string('cv')->nullable();

            // 🔹 Teacher Stats
            $table->integer('total_questions')->default(0);
            $table->decimal('wallet_balance', 10, 2)->default(0.00);
            $table->decimal('total_paid', 10, 2)->default(0.00);
            $table->decimal('pending', 10, 2)->default(0.00);

            // 🔹 Status
            $table->boolean('status')->default(true); // active/inactive

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
