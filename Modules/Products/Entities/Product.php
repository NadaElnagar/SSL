<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HomePage\Entities\CollectionProduct;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['canbe_reissued', 'currency_code', 'is_competitive_upgrade_supported', 'api_id', 'is_san_enable',
        'is_support_auto_install', 'issuance_time', 'max_san', 'min_san', 'product_code', 'product_description', 'product_name',
        'product_slug', 'reissue_days', 'site_seal', 'vendor_name', 'warranty', 'is_code_signing', 'isdv_product', 'isev_product',
        'is_code_signing', 'is_green_bar', 'is_malware_scan', 'is_mobile_friendly', 'is_no_of_server_free', 'isov_product'
        , 'is_scan_product', 'is_seal_in_search', 'is_vulnerability_assessment', 'is_wildcard', 'product_type'
    ];

    protected $attributes = ['CanbeReissued', 'CurrencyCode', 'IsCompetitiveUpgradeSupported', 'api_id', 'IsSanEnable',
        'IsSupportAutoInstall', 'IssuanceTime', 'MaxSan', 'MinSan', 'ProductCode', 'ProductDescription', 'ProductName',
        'ProductSlug', 'ReissueDays', 'SiteSeal', 'VendorName', 'Warranty', 'isCodeSigning', 'isDVProduct', 'isEVProduct',
        'isCodeSigning', 'isGreenBar', 'isMalwareScan', 'isMobileFriendly', 'isNoOfServerFree', 'isOVProduct', 'isScanProduct',
        'isSealInSearch', 'isVulnerabilityAssessment', 'isWildcard', 'ProductType'
    ];


    public function changeColumns($key)
    {
        $databaseColumn = implode('_', array_map('ucfirst', explode('_', $key)));

        return parent::changeColumns($databaseColumn);
    }

    public function productPrice()
    {
        return $this->hasMany(productPrice::class,'product_id','id');
    }
    public function collection()
    {
        return $this->hasMany(CollectionProduct::class,'product_id','id');
    }
}
