<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->string('description', 500);
            $table->double('price',11,2);
            $table->text('content');
            $table->integer('category_id');
            $table->integer('user_type')->nullable(); // 0:user; 1:admin
            $table->integer('user_id')->nullable();
            $table->integer('currency_id');
            $table->integer('location_id');
            $table->tinyInteger('status');
            $table->boolean('approve');
            $table->boolean('hot');
            $table->timestamp('exped_at');
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
        Schema::dropIfExists('products');
    }
}
