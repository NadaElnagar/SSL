<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function(Blueprint $table) {
            $table->renameColumn('PartnerOrderID','partner_order_i_d');
            $table->renameColumn('PurchaseDate','purchase_date');
            $table->renameColumn('PurchaseDateInUTC','purchase_date_in_u_t_c');
            $table->renameColumn('SiteSealurl','site_sealurl');
            $table->renameColumn('TheSSLStoreOrderID','the_s_s_l_store_order_i_d');
            $table->renameColumn('TinyOrderLink','tiny_order_link');
            $table->renameColumn('Token','token');
            $table->renameColumn('TokenCode','token_code');
            $table->renameColumn('TokenID','token_i_d');
            $table->renameColumn('isRefundApproved','is_refund_approved');
            $table->renameColumn('SANCount','s_a_n_count');
            $table->renameColumn('Validity','validity');
            $table->renameColumn('OrderExpiryDate','order_expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function(Blueprint $table) {
         //   $table->renameColumn('partner_order_i_d','PartnerOrderID');

        });
    }
}
