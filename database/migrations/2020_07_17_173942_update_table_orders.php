<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_name', 255)->nullable()->change();
            $table->string('order_phone')->nullable()->change();
            $table->string('order_address')->nullable()->change();
            $table->string('order_product')->nullable()->change();
            $table->text('order_comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_name', 255);
            $table->string('order_phone');
            $table->string('order_address');
            $table->string('order_product');
            $table->text('order_comment');
        });
    }
}
