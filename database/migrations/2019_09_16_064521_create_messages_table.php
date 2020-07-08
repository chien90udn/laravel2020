<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('email', 255);
            $table->string('phone', 50);
            $table->text('content');
            $table->integer('product_id');
            $table->integer('user_id_from');
            $table->integer('user_id_from_type'); 
            $table->integer('user_id_to');
            $table->integer('user_id_to_type');
            $table->tinyInteger('status'); 
            $table->boolean('approve');
            $table->integer('reply_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
