<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('type')->nullable();

            $table->double('unit_cost')->default(0);
            $table->double('unit_price')->default(0);

            $table->bigInteger("inventory_account_id")->unsigned()->nullable();
            $table->bigInteger("cost_of_sales_account_id")->unsigned()->nullable();
            $table->bigInteger("sales_account_id")->unsigned()->nullable();

            $table->foreign('inventory_account_id')->references('id')->on('accounts');
            $table->foreign('cost_of_sales_account_id')->references('id')->on('accounts');
            $table->foreign('sales_account_id')->references('id')->on('accounts');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('type');

            $table->dropForeign(['inventory_account_id']);
            $table->dropForeign(['cost_of_sales_account_id']);
            $table->dropForeign(['sales_account_id']);

            $table->dropColumn('inventory_account_id');
            $table->dropColumn('cost_of_sales_account_id');
            $table->dropColumn('sales_account_id');
        });
    }
};
