<?php


namespace Modules\Order\Http\Controllers;
use App\Http\Requests\pagination;
use App\Http\Services\SingletonService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Http\Requests\AutoRenew;
use Modules\Order\Http\Service\OrderService;


class OrderControllerApi extends Controller
{
    private $order;
    public function __construct()
    {
        $this->order = SingletonService::serviceInstance(OrderService::class);
    }

    public function getOrderHistory()
    {
        return $this->order->getOrderHistory();
    }
    public function getOrderHistoryByUserID($user_id)
    {
        return $this->order->getOrderHistory($user_id);
    }
    public function orderDetails($id)
    {
        return $this->order->getOrderItemsByID($id);
    }
    public function orderTransactionDetails(pagination $request)
    {
        return $this->order->orderTransactionDetails(null ,$request);
    }
    public function orderAutoRenew(AutoRenew $request)
    {
        return $this->order->autoRenew($request);
    }
    public function listOrder(pagination $request)
    {
        return $this->order->allOrdrs($request);
    }
    public function getOrdersByUserID($user,pagination $request)
    {
        if($user) {
            return $this->order->orderTransactionDetails($user,$request);
        }else{
                 return response()->json('', 400);
        }
    }
    public function userTransaction()
    {
        return $this->order->userHistoryTransaction();
    }
}
