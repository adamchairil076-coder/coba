<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder_name');

            $table->decimal('amount', 15, 2);

            $table->enum('status', ['success', 'failed'])->default('success');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}