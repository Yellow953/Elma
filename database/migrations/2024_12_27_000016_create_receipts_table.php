<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('currency_id');
            $table->date('date');
            $table->string('type')->default('receipt');
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
