<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('vat_number')->unique();

            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('receivable_account_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('receivable_account_id')->references('id')->on('accounts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
