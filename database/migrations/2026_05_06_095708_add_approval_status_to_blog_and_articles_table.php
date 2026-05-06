<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('blog_and_articles', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->after('thumbnail');
            $table->enum('approval_status', ['pending', 'approved'])
                ->default('approved')
                ->after('created_by');
        });
    }

    public function down()
    {
        Schema::table('blog_and_articles', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('approval_status');
        });
    }
};