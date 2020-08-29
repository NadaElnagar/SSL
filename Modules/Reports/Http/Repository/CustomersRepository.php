<?php


namespace Modules\Reports\Http\Repository;

use DB;
use Modules\Cart\Entities\Cart;
use Modules\Order\Entities\Order;
use Modules\Ticket\Entities\Ticket;
use Modules\Users\Entities\User;

class CustomersRepository
{

    public function index()
    {
        $orders = array();
        $users = User::where('is_admin',0)->get();
        if ($users) {
            foreach ($users as $user) {
                $result['user']= $user->email;
                $result['total_order']= $this->totalOrder($user->id);
                $result['total_cart']= ($this->totalCart($user->id)->cart)?$this->totalCart($user->id)->cart :0;
                $result['total_ticket']= $this->totalTicket($user->id);
                $result['total_wallet']= $this->totalWallet($user->id)->wallet_ballance;
                $result['total_money']= ($this->totalMoney($user->id)->money)?$this->totalMoney($user->id)->money :0;
                $orders[] = $result;
            }
        }
        return $orders;
    }

    private function totalCart($user_id)
    {
        return Cart::select(DB::raw("SUM(quantity) as cart"))->where('user_id', $user_id)->first();
    }

    private function totalTicket($user_id)
    {
        return Ticket::where('users_id', $user_id)->where('status', '!=', 3)->count();
    }

    private function totalWallet($user_id)
    {
        return User::where('id', $user_id)->select('wallet_ballance')->first();
    }

    private function totalMoney($user_id)
    {
        return Order::where('user_id', $user_id)->select(DB::raw('SUM(total_price) as money'))->first();
    }

    private function totalOrder($user_id)
    {
        $total_order = 0;
        $orders = Order::where('user_id', $user_id)->with('orderItems')->get()->pluck('orderItems');
        if ($orders) {
            foreach ($orders as $order) {
                $total_order += count($order);
            }
        }
        return $total_order;
    }
}
