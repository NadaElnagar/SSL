<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHpCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hp_collection', function (Blueprint $table) {
            $table->dropColumn('hp_subject_id');
            $table->dropColumn('product_price_id');
            $table->string('text');
            $table->string('lang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hp_collection', function (Blueprint $table) {
            $table->integer('hp_subject_id');
            $table->integer('product_price_id');
            $table->dropColumn('text');
            $table->dropColumn('lang');
            $table->integer('collection_id');
        });
    }
}
