<?php


namespace Modules\Reports\Http\Repository;


use DB;
use Modules\Cart\Entities\Cart;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\User;

class CartRepository
{

    public function index()
    {
        $result = array();
        $users = $this->users();
        if ($users['quantity']) {
            $result['total_cart'] = $this->total_Cart();
            foreach ($users['quantity'] as $user) {
                $user->start_cart = ($this->firstTimeCart($user['user_id']))->created_at;
                $user->last_update = ($this->lastUpdateUser($user['user_id']))->updated_at;
                $user->user_cart_details = $this->userCartDetails($user['user_id']);
                $result['cart'][] = $user;
            }
            return $result;
        } else {
            return __("messages.cart Empty");
        }
    }

    private function users()
    {
        $cart = Cart::select(DB::raw('SUM(quantity) as Quantity'), 'user_id')->with('user')->groupBY('user_id');
        $result['total_user'] = $cart->count();
        $result['quantity'] = $cart->get();
        return $result;
    }

    private function lastUpdateUser($user_id)
    {
        return Cart::select('updated_at')->where('user_id', $user_id)->orderBy('updated_at', 'DESC')->first();
    }

    private function firstTimeCart($user_id)
    {
        return Cart::select('created_at')->where('user_id', $user_id)->orderBy('created_at', 'ASC')->first();
    }

    public function userCartDetails($user_id)
    {
        $result = array();
        $cart = Cart::where('user_id', $user_id)->with('productPrice')
            ->select('id', 'quantity', 'product_price_id')->get();
        if ($cart) {
            foreach ($cart as $item) {
                $product_id = $item->product_price->product_id;
                $item->product_name = (Product::where('id', $product_id)->select('product_name')->first())->product_name;
                $result[] = $item;
            }
            return $result;
        } else {
            return false;
        }
    }

    private function totalCart()
    {
        return Cart::select(DB::raw('SUM(quantity) as total_cart'))->pluck('total_cart');
    }
}

