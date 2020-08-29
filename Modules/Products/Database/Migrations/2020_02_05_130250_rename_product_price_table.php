<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_price', function(Blueprint $table) {
            $table->renameColumn('NumberOfMonths','number_of_months');
            $table->renameColumn('NumberOfServer','number_of_server');
            $table->renameColumn('Price','price');
            $table->renameColumn('PricePerAdditionalSAN','price_per_additional_s_a_n');
            $table->renameColumn('PricePerAdditionalServer','price_per_additional_server');
            $table->renameColumn('SRP','s_r_p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
