<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->enum('approval_status', ['pending', 'approved'])
                  ->default('approved')
                  ->after('status');
        });
    }

    public function down()
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};