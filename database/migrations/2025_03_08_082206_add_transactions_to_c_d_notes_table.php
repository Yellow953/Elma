<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('c_d_notes', function (Blueprint $table) {
            $table->string('transactions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('c_d_notes', function (Blueprint $table) {
            $table->dropColumn('transactions');
        });
    }
};
