<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_id');
            $table->unsignedBigInteger('item_id');
            $table->double('quantity')->unsigned();
            $table->double('unit_cost')->unsigned();
            $table->double('total_cost')->unsigned();
            $table->double('vat')->unsigned();
            $table->double('rate')->unsigned();
            $table->double('total_cost_after_vat')->unsigned();
            $table->double('total_after_landed_cost')->unsigned();
            $table->double('total_foreign_cost')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};
