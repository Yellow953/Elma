<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_voucher_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('currency_id');
            $table->double('debit')->unsigned()->default(0);
            $table->double('credit')->unsigned()->default(0);
            $table->double('balance')->unsigned()->default(0);
            $table->unsignedBigInteger('foreign_currency_id')->nullable();
            $table->double('foreign_debit')->unsigned()->nullable();
            $table->double('foreign_credit')->unsigned()->nullable();
            $table->double('foreign_balance')->unsigned()->nullable();
            $table->double('rate')->unsigned()->nullable();
            $table->boolean('hidden')->default(false);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('journal_voucher_id')->references('id')->on('journal_vouchers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('foreign_currency_id')->references('id')->on('currencies');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
