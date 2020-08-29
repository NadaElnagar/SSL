<?php


namespace Modules\Cart\Http\Services;

use App\Http\Services\ResponseService;
use App\Http\Services\SingletonService;
use Illuminate\Http\Response;
use Modules\Cart\Http\Repository\CartRepository;

class CartServices extends ResponseService
{
    private $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart =    SingletonService::serviceInstance(CartRepository::class);
    }

    public function addToCart($user_id, $request)
    {
        if (!isset($request['quantity'])) {
            $quantity = 1;
        } else {
            $quantity = $request['quantity'];
        }
        $product_price_id = $request['product_price_id'];
        $result = $this->cart->addToCart($user_id, $product_price_id, $quantity);
        if ($result == 1) {
            return $this->responseWithSuccess(__('messages.Product Added To Cart'));
        } elseif ($result == 2) {
            return $this->responseWithSuccess(__('messages.Product Removed!'));
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, null);
        }
    }

    public function userCart($user_id)
    {
        $result = $this->cart->userCart($user_id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function userCartCount($user_id)
    {
        $result = $this->cart->userCartCount($user_id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function Calculation($user_id)
    {
        $result = $this->cart->getTotalCart($user_id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
}
