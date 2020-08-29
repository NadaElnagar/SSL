<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
    protected $table = "wallet";
   protected $appends = array('order_details');

    public function getOrderDetailsAttribute()
    {
        return  Order::where('id',$this->order_id)->with('orderItems')->get();
     }
}
