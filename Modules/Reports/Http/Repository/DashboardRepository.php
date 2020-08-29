<?php


namespace Modules\Reports\Http\Repository;


use Modules\Category\Entities\Brands;
use Modules\Category\Entities\Category;
use Modules\Order\Entities\OrderItems;
use Modules\Order\Entities\wallet;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\User;

class DashboardRepository
{
    public function index()
    {
        $result = array();
        $result['total_orders'] = $this->totalOrders();
        $result['total_payment'] = $this->totalPayment();
        $result['total_product'] = $this->totalPayment();
        $result['total_inactive_product'] = $this->totalInactiveProduct();
        $result['total_active_product'] = $this->totalActiveProduct();
        $result['total_users'] = $this->totalUsers();
        $result['total_category'] = $this->totalCategory();
        $result['total_brand'] = $this->totalBrand();
        return $result;
    }

    /*get total order */
    private function totalOrders()
    {
        return OrderItems::count();
    }
    /*get total payment */
    private function totalPayment()
    {
        return wallet::sum('price');
    }
    /*get in active product (product which user can't show it  */
    private function totalInactiveProduct()
    {
        return Product::where('active',0)->count();
    }
    /*product user can show it */
    private function totalActiveProduct()
    {
        return Product::where('active',1)->count();
    }
    /*Number of product get from ssl*/
    private function totalProduct()
    {
        return Product::count();
    }
    /*total number of users registed in out frontend */
    private function totalUsers()
    {
        return User::where('is_admin',0)->count();
    }
    /*Number of category*/
    private function totalCategory()
    {
        return Category::count();
    }
    /*number of brand*/
    private function totalBrand()
    {
       return Brands::count();
    }
}
