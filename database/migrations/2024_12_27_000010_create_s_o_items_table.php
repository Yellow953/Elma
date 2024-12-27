<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('s_o_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("so_id")->unsigned();
            $table->bigInteger("item_id")->unsigned();
            $table->double('quantity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('so_id')->references('id')->on('s_o_s');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down()
    {
        Schema::dropIfExists('s_o_items');
    }
};
