<?php


namespace Modules\Reports\Http\Repository;


use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItems;
use Modules\Order\Entities\OrderTransaction;

class OrdersRepository
{
    public function index($request)
    {
        $result['total_order'] = $this->totalOrder();
        $result['total_money'] = ($this->totalMoney())->total_price;
        $result['status'] = $this->status();
        $result['orders_history'] =  $this->ordersHistory($request);
        return $result;
    }
    private function totalOrder()
    {
      return  OrderItems::count();
    }
    private function totalMoney()
    {
        return Order::select(DB::raw('SUM(total_price) as total_price'))->first();
    }
    private function status()
    {
        return OrderTransaction::select(DB::raw('count(*) as total'),'major_status')->groupBy('major_status')->get();
    }
    private function ordersHistory($request)
    {

        $limit = $request['limit'];
        $offset = $request['offset'] * $limit;
        $to =  date('Y-m-d', strtotime($request['to']));
        $from =  date('Y-m-d', strtotime($request['from']));
        $orders= DB::table('order')
            ->join('order_items','order_items.order_id','order.id')
            ->join('order_transaction','order_transaction.order_item_id','order_items.id')
            ->join('product_price','product_price.id','order_items.price_id')
            ->join('product','product.id','product_price.product_id')
            ->join('users','users.id','order.user_id')
            ->select('order_transaction.id','product.id as product_id','product.product_name','order_transaction.major_status'
                ,'order_transaction.certificate_end_date as CertificateEndDate','order_transaction.order_expiry_date as OrderExpiryDate'
                ,'order_items.price','users.email as userMail','order_transaction.certificate_start_date','order_items.price'
                ,'product_price.number_of_months','product_price.srp','order.created_at')
            ->whereDate('order.created_at','>=',$from)
            ->whereDate('order.created_at','<=',$to);
        if (isset($limit) && isset($offset)) {
            $count = $orders->count();
            $order = $orders->limit($limit)->offset('offset')->get();
            return array('count'=>$count,'order'=>$order);
        } else {
            return$orders->get();
        }
    }
}
