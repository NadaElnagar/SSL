<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='order';
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
