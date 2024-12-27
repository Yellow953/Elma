<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('c_d_notes', function (Blueprint $table) {
            $table->id();
            $table->string('cdnote_number')->unique();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->string('description');
            $table->date('date');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('foreign_currency_id')->nullable();
            $table->double('rate')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('journal_voucher_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('foreign_currency_id')->references('id')->on('currencies');
            $table->foreign('journal_voucher_id')->references('id')->on('journal_vouchers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_d_notes');
    }
};
