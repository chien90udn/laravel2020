<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('translations', function(Blueprint $table) {
            $table->dropColumn('lag_content');
            $table->dropColumn('lang_id');
            $table->text('lang_content');
            $table->string('lang_code',50);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('translations', function(Blueprint $table) {
            $table->text('lag_content');
            $table->integer('lang_id');
            $table->dropColumn('lang_content');
            $table->dropColumn('lang_code');


        });
    }
}
