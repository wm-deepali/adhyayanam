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
        Schema::create('home_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email_address')->nullable();
            $table->string('country_code', 10);
            $table->string('mobile_number', 20);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_enquiries');
    }
};
