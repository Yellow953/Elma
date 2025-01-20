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
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('tax_id');
            $table->date('date');
            $table->string('type')->default('invoice');
            $table->unsignedBigInteger('sales_order_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('shipment_id')->references('id')->on('shipments');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
