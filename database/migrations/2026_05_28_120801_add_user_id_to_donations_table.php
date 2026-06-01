<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToDonationsTable extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}