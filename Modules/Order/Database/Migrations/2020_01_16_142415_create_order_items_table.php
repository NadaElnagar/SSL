<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('price');
            $table->integer('price_id');
            $table->string('PartnerOrderID');
            $table->string('PurchaseDate');
            $table->string('PurchaseDateInUTC');
            $table->string('SiteSealurl');
            $table->integer('TheSSLStoreOrderID');
            $table->string('TinyOrderLink');
            $table->string('Token');
            $table->string('TokenCode');
            $table->string('TokenID');
            $table->string('isRefundApproved');
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
        Schema::dropIfExists('order_items');
    }
}
