<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->integer('user_id_from_type')->default(0)->change();
            $table->integer('user_id_to_type')->default(0)->change();
            $table->integer('status')->default(0)->change();
            $table->boolean('approve')->default(0)->change();
            $table->string('name',255)->nullable()->change();
            $table->string('email', 255)->nullable()->change();
            $table->string('phone', 50)->nullable()->change();
            $table->integer('product_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->integer('user_id_from_type');
            $table->integer('user_id_to_type');
            $table->tinyInteger('status');
            $table->boolean('approve');
            $table->string('name',255);
            $table->string('email', 255);
            $table->string('phone', 50);
            $table->integer('product_id');
        });
    }
}
