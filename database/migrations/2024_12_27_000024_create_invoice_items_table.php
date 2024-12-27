<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('item_id');
            $table->string('location')->nullable();
            $table->double('quantity')->unsigned();
            $table->double('unit_cost')->unsigned();
            $table->double('total_cost')->unsigned();
            $table->double('unit_price')->unsigned();
            $table->double('total_price')->unsigned();
            $table->double('vat')->unsigned();
            $table->double('rate')->unsigned();
            $table->double('total_price_after_vat')->unsigned();
            $table->double('total_foreign_price')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};