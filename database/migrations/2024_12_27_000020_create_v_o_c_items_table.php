<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('v_o_c_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voc_id');
            $table->unsignedBigInteger('account_id');
            $table->double('amount')->unsigned();
            $table->double('tax')->unsigned();
            $table->double('total')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('voc_id')->references('id')->on('v_o_c_s');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('v_o_c_items');
    }
};
