<?php

namespace Modules\HomePage\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\productPrice;

class CollectionProduct extends Model
{
    protected $table = "collection_product";
   // protected $appends= array('product_details');
    public function product()
    {
        return $this->hasMany(Product::class,'id','product_id');
    }


}
