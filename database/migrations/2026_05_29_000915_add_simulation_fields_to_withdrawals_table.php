<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSimulationFieldsToWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            if (!Schema::hasColumn('withdrawals', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('withdrawals', 'account_number')) {
                $table->string('account_number')->nullable()->after('bank_name');
            }

            if (!Schema::hasColumn('withdrawals', 'account_holder_name')) {
                $table->string('account_holder_name')->nullable()->after('account_number');
            }

            if (!Schema::hasColumn('withdrawals', 'status')) {
                $table->enum('status', ['success', 'failed'])
                      ->default('success')
                      ->after('amount');
            }
        });
    }

    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            if (Schema::hasColumn('withdrawals', 'bank_name')) {
                $table->dropColumn('bank_name');
            }

            if (Schema::hasColumn('withdrawals', 'account_number')) {
                $table->dropColumn('account_number');
            }

            if (Schema::hasColumn('withdrawals', 'account_holder_name')) {
                $table->dropColumn('account_holder_name');
            }

            if (Schema::hasColumn('withdrawals', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}