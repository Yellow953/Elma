<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('p_o_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("po_id")->unsigned();
            $table->bigInteger("item_id")->unsigned();
            $table->double('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('po_id')->references('id')->on('p_o_s');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p_o_items');
    }
};
