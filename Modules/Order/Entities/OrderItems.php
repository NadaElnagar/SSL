<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\productPrice;

class OrderItems extends Model
{
    protected $table='order_items';
    protected $fillable =['PartnerOrderID','PurchaseDate','PurchaseDateInUTC','SiteSealurl','TheSSLStoreOrderID',
    'TinyOrderLink','Token','TokenCode','TokenID',"isRefundApproved","order_id","price_id","price","OrderExpiryDate"
        ,"TheSSLStoreOrderID","SANCount","Validity"];

    protected $attributes =['partner_orderid','purchase_date','purchase_date_inutc','site_sealurl'
        ,'thessl_store_orderid', 'tiny_order_link','token','token_code','tokenid',"is_refund_approved"
        ,"order_id","price_id","price","OrderExpiryDate"
        ,"san_count","validity"];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function productPrice()
    {
        return $this->belongsTo(productPrice::class,'price_id','id');
    }
}
