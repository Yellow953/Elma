<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('foreign_currency_id')->nullable();
            $table->double('rate')->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->string('source')->default('system');
            $table->string('status')->default('unposted');
            $table->string('batch')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('foreign_currency_id')->references('id')->on('currencies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_vouchers');
    }
};
