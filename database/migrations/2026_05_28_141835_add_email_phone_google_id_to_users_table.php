<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailPhoneGoogleIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('username');
            $table->string('phone', 13)->nullable()->after('email');
            $table->string('google_id')->nullable()->after('phone');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'google_id']);
        });
    }
}