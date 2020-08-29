<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class productPrice extends Model
{
    protected $table = 'product_price';
    protected $fillable=['product_id','NumberOfMonths','NumberOfServer','Price','PricePerAdditionalSAN','PricePerAdditionalServer'
    ,'SRP'];

    protected $attributes = ['product_id','number_of_months','number_of_server','price','price_per_additionalsan'
    ,'price_per_additional_server','srp'];
    protected $appends = array('official_price');


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function getOfficialPriceAttribute()
    {
        if($this->admin_price != 0 ){
            return $this->admin_price ;
        }else{
            return $this->price;
        }
    }
}
