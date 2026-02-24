<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('feedback_testimonial', function (Blueprint $table) {
            $table->tinyInteger('rating')->nullable()->after('type');
            $table->string('designation')->nullable()->after('username');
        });
    }

    public function down()
    {
        Schema::table('feedback_testimonial', function (Blueprint $table) {
            $table->dropColumn(['rating','designation']);
        });
    }
};