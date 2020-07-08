<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('region_master_id');
            $table->integer('city_master_id');
            $table->string('address', 255);
            $table->integer('floor_id_from');
            $table->integer('floor_id_to');
            $table->integer('area_used');
            $table->integer('complete_time');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('region_master_id');
            $table->dropColumn('city_master_id');
            $table->dropColumn('address');
            $table->dropColumn('floor_id_from');
            $table->dropColumn('floor_id_to');
            $table->dropColumn('area_used');
            $table->dropColumn('complete_time');
        });
    }
}
