<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('v_o_c_s', function (Blueprint $table) {
            $table->id();
            $table->string('voc_number')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_invoice')->unique();
            $table->date('date');
            $table->text('description');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('foreign_currency_id')->nullable();
            $table->double('rate')->nullable();
            $table->string('type')->default('VOC Transaction');
            $table->unsignedBigInteger('journal_voucher_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('foreign_currency_id')->references('id')->on('currencies');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('journal_voucher_id')->references('id')->on('journal_vouchers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('v_o_c_s');
    }
};