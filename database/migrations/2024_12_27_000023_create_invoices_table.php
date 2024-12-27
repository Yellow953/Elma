<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('foreign_currency_id')->nullable();
            $table->double('rate')->nullable();
            $table->unsignedBigInteger('tax_id');
            $table->date('date');
            $table->unsignedBigInteger('journal_voucher_id');
            $table->string('type')->default('invoice');
            $table->unsignedBigInteger('so_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('foreign_currency_id')->references('id')->on('currencies');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('journal_voucher_id')->references('id')->on('journal_vouchers');
            $table->foreign('so_id')->references('id')->on('s_o_s');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
