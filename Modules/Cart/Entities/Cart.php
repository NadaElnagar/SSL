<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\productPrice;
use Modules\Users\Entities\User;

class Cart extends Model
{
    protected $table='cart';
    public function productPrice()
    {
       return $this->belongsTo(productPrice::class,'product_price_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
