<?php


namespace Modules\WeAcceptPayment\Http\Repository;


use Modules\Order\Entities\wallet;
use Modules\WeAcceptPayment\Entities\LogPayment;

class WeAcceptRepository
{

    public function wallet($data)
    {
        $wallet = new wallet();
        $wallet->order_id = $data['order_id'];
        $wallet->we_Accept_order_id = $data['we_Accept_order_id'];
        $wallet->user_id = $data['user_id'];
        $wallet->price = $data['total_price'];
        $wallet->save();
        return true;
    }
    public function logPayment($data)
    {
        $log = new LogPayment();
        $log->order_id = $data['order'];
        $log->we_Accept_order_id = $data['merchant_order_id'];
        $log->pending = $data['pending'];
        $log->success = $data['success'];
        $log->save();
        return true;
    }
}
