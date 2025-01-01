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
            $table->string('status')->default('new');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->date('shipping_date');
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
