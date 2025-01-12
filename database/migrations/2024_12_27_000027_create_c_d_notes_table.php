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
            $table->string('type');
            $table->double('amount')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_d_notes');
    }
};
