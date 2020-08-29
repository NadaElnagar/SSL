<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CanbeReissued',4);
            $table->string('CurrencyCode',4);
            $table->integer('api_id');
            $table->string('IsCompetitiveUpgradeSupported',5);
            $table->string('IsSanEnable',5);
            $table->string('IsSupportAutoInstall',5);
            $table->string('IssuanceTime',50);
            $table->string('MaxSan',10);
            $table->string('MinSan',10);
            $table->string('ProductCode',250);
            $table->text('ProductDescription');
            $table->string('ProductName',300);
            $table->string('ProductSlug',250);
            $table->integer('ProductType');
            $table->integer('ReissueDays');
            $table->string('SiteSeal',255);
            $table->string('VendorName',255);
            $table->string('Warranty',255);
            $table->string('isCodeSigning',6);
            $table->string('isDVProduct',6);
            $table->string('isEVProduct',6);
            $table->string('isGreenBar',6);
            $table->string('isMalwareScan',6);
            $table->string('isMobileFriendly',6);
            $table->string('isNoOfServerFree',6);
            $table->string('isOVProduct',6);
            $table->string('isScanProduct',6);
            $table->string('isSealInSearch',6);
            $table->string('isVulnerabilityAssessment',6);
            $table->string('isWildcard',6);
            $table->tinyInteger('active')->default(0);
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
        Schema::dropIfExists('product');
    }
}
