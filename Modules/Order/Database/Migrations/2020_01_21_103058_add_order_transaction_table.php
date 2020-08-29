<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_item_id');
            $table->string('status');
            $table->string('CertificateEndDate');
            $table->string('CertificateStartDate');
            $table->string('OrderExpiryDate');
            $table->string('MajorStatus');
            $table->string('isTinyOrder');
            $table->integer('TSSOrganizationId');
            $table->integer('TheSSLStoreOrderID');
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
        Schema::dropIfExists('order_transaction');
    }
}
