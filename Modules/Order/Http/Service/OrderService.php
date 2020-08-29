<?php

namespace Modules\Order\Http\Service;
use App\Http\Services\ResponseService;
use App\Http\Services\SingletonService;
use http\Env\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Http\Repository\OrderRepository;

class OrderService extends ResponseService
{
    private  $order;
    public function __construct()
    {
        $this->order = SingletonService::serviceInstance(OrderRepository::class);
    }
    public function getOrderHistory($user_id = null)
    {
       if(!$user_id)$user_id = Auth::user()->id;
        $result = $this->order->UserOrderHistory($user_id);
        if($result){
           return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function getOrderItemsByID($id)
    {
        $result = $this->order->getOrderItemsByID($id);
        if($result){
            return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function orderTransactionDetails($user = null,$request)
    {
        if(!$user){$user = Auth::user()->id;}
        $result = $this->order->userOrderFullDetails($user,$request);
        if($result){
            return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function autoRenew($request)
    {
        $ids = explode(',',$request['id']);
        $status = $request['status'];
        $result = $this->order->autoRenew($ids,$status);
        if($result){
            return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function allOrdrs($request)
    {
        $result = $this->order->allOrdrs($request);
        if($result){
            return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }

    public function userHistoryTransaction()
    {
        $user_id = Auth::user()->id;
        $result = $this->order->userHistoryTransaction($user_id);
        if($result){
            return $this->responseWithSuccess($result);
        }else{
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
}
