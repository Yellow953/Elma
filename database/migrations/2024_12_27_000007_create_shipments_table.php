<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_number');
            $table->string('mode');
            $table->string('departure');
            $table->string('arrival');
            $table->string('commodity');
            $table->unsignedBigInteger('due_from_id');
            $table->unsignedBigInteger('shipper_id');
            $table->date('shipping_date');
            $table->date('loading_date')->nullable();
            $table->string('vessel_name');
            $table->date('vessel_date');
            $table->string('booking_number');
            $table->string('carrier_name');
            $table->string('consignee_name');
            $table->string('consignee_country');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('due_from_id')->references('id')->on('clients');
            $table->foreign('shipper_id')->references('id')->on('clients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
