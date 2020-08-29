<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNameOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_transaction', function (Blueprint $table) {
             $table->renameColumn( 't_s_s_organization_id','tss_organization_id');
            $table->renameColumn( 'the_s_s_l_store_order_i_d','thessl_store_orderid');
        });
        Schema::table('order_items', function(Blueprint $table) {
            $table->renameColumn( 'partner_order_i_d','partner_orderid');
             $table->renameColumn( 'purchase_date_in_u_t_c','purchase_date_inutc');
             $table->renameColumn( 'the_s_s_l_store_order_i_d','thessl_store_orderid');
             $table->renameColumn( 'token_i_d','tokenid');
             $table->renameColumn( 's_a_n_count','san_count');
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
