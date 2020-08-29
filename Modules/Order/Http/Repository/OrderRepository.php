<?php


namespace Modules\Order\Http\Repository;


use App\Events\OrderItem;
use App\Http\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItems;
use Modules\Order\Entities\OrderTransaction;
use Modules\Order\Entities\wallet;

class OrderRepository
{
    public function getProductDetailsByPriceID($price_id)
    {
        // TODO: Implement getProductDetailsByPriceID() method.
        return DB::table('product')->join('product_price', 'product_price.product_id', 'product.id')
            ->where('product_price.id', $price_id)->first();
    }

    public function SaveNewOrder($user_id, $total_price)
    {
        // TODO: Implement SaveResponseNewOrder() method.
        $order = new Order();
        $order->user_id = $user_id;
        $order->total_price = $total_price;
        if ($order->save()) {
            return $order;
        } else {
            return false;
        }
    }

    public function SaveOrderItems($order_id, $price_id, $price, $response)
    {
        $order = new OrderItems();
        $response['order_id'] = $order_id;
        $response['price'] = $price;
        $response['price_id'] = $price_id;

        foreach ($order->changeColumns() as $key=>$field) {
            $order_name =  [change_parameter_lowercase($field)] ;
            $order->$order_name = $response[$field];
            unset($order[$key]);
        }
        if ($order->save()) {
            $order->status = 'new';
            event(new OrderItem($order));
            return true;
        } else {
            return $price_id;
        }
    }

    public function UserOrderHistory($user_id)
    {
        return Order::where('user_id', $user_id)->get();
    }

    public function getOrderItemsByID($order_id)
    {
        return OrderItems::where('order_id',$order_id)->get();
    }
    public function orderTransaction($order, $order_item_id,$status)
    {
        $order_transaction = new OrderTransaction();
        $order['order_item_id'] = $order_item_id;
        $order['status'] = $status;
        $order['major_status'] = $order['OrderStatus']['MajorStatus'];
        $order['is_tiny_order'] = $order['OrderStatus']['isTinyOrder'];
        foreach ($order_transaction->changeColumns() as $key=>$field)
        {
            $order_transaction_name =  [change_parameter_lowercase($field)] ;
            $order_transaction->$order_transaction_name = $order[$field];
            unset($order_transaction[$key]);
        }
        if($transaction = $order_transaction->save())
        {
            return true;
        }else{
            return false;
        }
    }
    public function userOrderFullDetails($user_id,$request)
    {
        $limit    = $request['limit'];
        $offset   = $request['offset'] * $limit;
        $orders= DB::table('order')
            ->join('order_items','order_items.order_id','order.id')
            ->join('order_transaction','order_transaction.order_item_id','order_items.id')
            ->join('product_price','product_price.id','order_items.price_id')
            ->join('product','product.id','product_price.product_id')
            ->join('users','users.id','order.user_id')
            ->select('order_transaction.id','product.id as product_id','product.product_name','order_transaction.major_status'
                ,'order_transaction.certificate_end_date','order_transaction.certificate_start_date','order_items.price'
            ,'product_price.number_of_months','product_price.srp')
             ->where('order.user_id',$user_id);
        $order_repository = (new BaseRepository())->paginationRepository($request,$orders);
        $result['count']= $order_repository['count'];
        $result['orders']= $order_repository['data'];
        return $result;
    }
    public function autoRenew($ids,$status)
    {
        foreach ($ids as $id){
             OrderTransaction::where('id',$id)->update(['auto_renew'=>$status]);
        }
        return true;
    }
    public function deleteOrder($order_id)
    {
       return Order::find($order_id)->delete();
    }
    public function allOrdrs($request)
    {
        $orders= DB::table('order')
        ->join('order_items','order_items.order_id','order.id')
        ->join('order_transaction','order_transaction.order_item_id','order_items.id')
        ->join('product_price','product_price.id','order_items.price_id')
        ->join('product','product.id','product_price.product_id')
        ->join('users','users.id','order.user_id')
        ->select('order_transaction.id','product.id as product_id','product.product_name','order_transaction.major_status'
        ,'order_transaction.certificate_end_date','order_transaction.certificate_start_date','order_items.price'
            ,'order_items.price','users.email as userMail','order_transaction.certificate_start_date','order_items.price'
            ,'product_price.number_of_months','product_price.srp');
        $order_repository = (new BaseRepository())->paginationRepository($request,$orders);
        $result['count']= $order_repository['count'];
        $result['orders']= $order_repository['data'];
        return $result;
    }
    public function userHistoryTransaction($user_id)
    {
        return wallet::where('user_id',$user_id)->get();
    }
}
