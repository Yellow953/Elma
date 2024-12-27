<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('c_d_note_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cdnote_id');
            $table->unsignedBigInteger('account_id');
            $table->double('amount')->unsigned();
            $table->double('tax')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cdnote_id')->references('id')->on('c_d_notes');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_d_note_items');
    }
};
