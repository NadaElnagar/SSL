<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    protected $table = "order_transaction";
    protected $fillable=['order_item_id','status','CertificateEndDate','CertificateStartDate','OrderExpiryDate'
    ,'MajorStatus','isTinyOrder','TSSOrganizationId','TheSSLStoreOrderID'];
    protected $attributes = ['order_item_id','status','certificate_end_date','certificate_start_date'
    ,'order_expiry_date','major_status','is_tiny_order','tss_organization_id','thessl_store_orderid'];
}
