<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function(Blueprint $table) {
            $table->renameColumn('CanbeReissued','canbe_reissued');
            $table->renameColumn('CurrencyCode','currency_code');
            $table->renameColumn('IsCompetitiveUpgradeSupported','is_competitive_upgrade_supported');
            $table->renameColumn('IsSanEnable','is_san_enable');
            $table->renameColumn('IsSupportAutoInstall','is_support_auto_install');
            $table->renameColumn('IssuanceTime','issuance_time');
            $table->renameColumn('MaxSan','max_san');
            $table->renameColumn('MinSan','min_san');
            $table->renameColumn('ProductCode','product_code');
            $table->renameColumn('ProductDescription','product_description');
            $table->renameColumn('ProductName','product_name');
            $table->renameColumn('ProductSlug','product_slug');
            $table->renameColumn('ProductType','product_type');
            $table->renameColumn('ReissueDays','reissue_days');
            $table->renameColumn('SiteSeal','site_seal');
            $table->renameColumn('VendorName','vendor_name');
            $table->renameColumn('Warranty','warranty');
            $table->renameColumn('isCodeSigning','is_code_signing');
            $table->renameColumn('isDVProduct','is_d_v_product');
            $table->renameColumn('isEVProduct','is_e_v_product');
            $table->renameColumn('isGreenBar','is_green_bar');
            $table->renameColumn('isMalwareScan','is_malware_scan');
            $table->renameColumn('isMobileFriendly','is_mobile_friendly');
            $table->renameColumn('isNoOfServerFree','is_no_of_server_free');
            $table->renameColumn('isOVProduct','is_o_v_product');
            $table->renameColumn('isScanProduct','is_scan_product');
            $table->renameColumn('isSealInSearch','is_seal_in_search');
            $table->renameColumn('isVulnerabilityAssessment','is_vulnerability_assessment');
            $table->renameColumn('isWildcard','is_wildcard');
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
