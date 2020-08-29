<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOrderTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_transaction', function (Blueprint $table) {
             $table->renameColumn('CertificateEndDate','certificate_end_date');
            $table->renameColumn('CertificateStartDate','certificate_start_date');
            $table->renameColumn('OrderExpiryDate','order_expiry_date');
            $table->renameColumn('MajorStatus','major_status');
            $table->renameColumn('isTinyOrder','is_tiny_order');
            $table->renameColumn('TSSOrganizationId','t_s_s_organization_id');
            $table->renameColumn('TheSSLStoreOrderID','the_s_s_l_store_order_i_d');
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
