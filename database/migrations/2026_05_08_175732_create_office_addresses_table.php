<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('office_addresses', function (Blueprint $table) {

            $table->id();

            $table->string('office_type');

            $table->text('address');

            $table->string('phone')->nullable();

            $table->string('email')->nullable();

            $table->longText('map_embbed')->nullable();

            $table->integer('sort_order')->default(0);

            $table->boolean('status')->default(1);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('office_addresses');
    }
};