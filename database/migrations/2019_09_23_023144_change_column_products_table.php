<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->integer('user_type')->default(0)->change(); // 0:user; 1:admin
            $table->integer('status')->default(1)->change();
            $table->boolean('approve')->default(0)->change();
            $table->boolean('hot')->default(0)->change();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->integer('user_type')->nullable(); // 0:user; 1:admin
            $table->tinyInteger('status');
            $table->boolean('approve');
            $table->boolean('hot');

        });
    }
}
