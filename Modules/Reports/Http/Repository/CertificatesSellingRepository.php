<?php


namespace Modules\Reports\Http\Repository;


use Modules\Cart\Entities\Cart;
use Modules\Order\Entities\OrderItems;
use Modules\Products\Entities\productPrice;
use DB;

class CertificatesSellingRepository
{
    private $limit = 5;

    public function index()
    {
        $result['top_selling'] = $this->topSelling();
        $result['low_selling'] = $this->lowSelling();
        $result['orders'] = $this->orders();
        return $result;
    }

    private function topSelling()
    {
        return OrderItems::with(['productPrice'=>function($q){
            $q->select('id','price','number_of_months','product_id')->with(['product'=>function($q){
                return $q->select('id','product_name');
            }]);
        }])->groupBy('id')
            ->orderBy('id')->limit($this->limit)->get()->pluck('productPrice');
    }

    private function lowSelling()
    {
        $product_price_ids = productPrice::whereIn('product_id', function ($q) {
            return $q->select('id')->from('product')->where('active', 1);
        })->whereNotIn('id', function ($q) {
            return $q->select('price_id')->from('order_items');
        })->select('product_id', 'number_of_months', 'price')
            ->with(['product'=>function($q) {
            return $q->select('id','product_name');
            }])->limit($this->limit)->get();
        if ($product_price_ids) {
            return $product_price_ids;
        } else {
            return array();
        }
    }

    private function orders()
    {
        $result = array();
        $orders = OrderItems::select(DB::raw('sum(price) as total_money'), DB::raw('count(*) as total_order'), 'price_id')
            ->groupBy('price_id')->get();
        if ($orders) {
            foreach ($orders as $order) {
                $order->number_cart = Cart::where('product_price_id', $order['price_id'])->count();
                $order->price = productPrice::where('id',$order['price_id'])
                    ->select('product_id','number_of_months')->with(['product'=>function($q){
                        return $q->select('id','product_name');
                    }])->get();
                $result[] = $order;
            }
            return $result;
        } else {
            return $result;
        }
    }
}
