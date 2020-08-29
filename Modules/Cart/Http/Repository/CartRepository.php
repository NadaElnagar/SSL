<?php


namespace Modules\Cart\Http\Repository;


use Modules\Cart\Entities\Cart;
use DB;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\productPrice;
use Carbon\Carbon;

class CartRepository
{

    public function addToCart($user_id, $product_price_id,$quantity)
  {
      $check = DB::table('cart')->where('user_id',$user_id)->where('product_price_id',$product_price_id)->first();
      if(!$check && $quantity !=0) {
         return $this->addNewToCart($user_id,$product_price_id,$quantity);
      }else{
        if ($quantity>0 &&$quantity !=0) {
              return $this->updateCart($user_id,$product_price_id,$quantity);
          }else{
              return $this->deleteFromCart($user_id,$product_price_id);
          }
      }
  }

  private function addNewToCart($user_id, $product_price_id,$quantity)
  {
      $cart = new Cart();
      $cart->user_id          = $user_id;
      $cart->product_price_id = $product_price_id;
      $cart->quantity         = $quantity;
      $cart->created_at       = Carbon::now()->toDateTimeString();
      if($result = $cart->save()){
          return $result;
      }else{
          return false;
      }
  }
  private function updateCart($user_id, $product_price_id,$quantity)
  {
      $result = Cart::where('user_id', $user_id)->where('product_price_id', $product_price_id)
          ->update(['quantity' => $quantity,'updated_at'=> Carbon::now()->toDateTimeString()]);
      return $result;
  }
  private function deleteFromCart($user_id, $product_price_id)
{
    if ($result = Cart::where('user_id', $user_id)->where('product_price_id', $product_price_id)->delete()) {
        return 2 ;
    }else{
        return $result ;
    }
}
  public function userCart($user_id)
  {
      $result = array();
      $product_price = DB::table('product_price')->join('cart','cart.product_price_id','product_price.id')
          ->where('cart.user_id',$user_id)->get();
      if($product_price){
       foreach ($product_price as $price){
       $product = Product::where('id',$price->product_id)->first();
           $product->product_price = $price;
           $result []= $product;
       }
       return $result;
      }else{
          return false;
      }
  }
  public function userCartCount($user_id)
  {
      // TODO: Implement yourCartCounter() method.
      return Cart::where('user_id',$user_id)->count();
  }
  public function emptyUserCart($user_id)
  {
      return Cart::where('user_id',$user_id)->delete();
  }
  public function updateUserCart($price_id,$user_id)
  {
     $user_cart =  Cart::where('user_id',$user_id)->whereNotIn('product_price_id',$price_id)->get();
     if($user_cart )
     {
         foreach ($user_cart as $cart){
             Cart::where('id',$cart->id)->delete();
         }
         return true;
     }
     else{
         return false;
     }
  }
  public function getTotalPrice($user_id)
  {
      $total_price = 0;
     $products = Cart::where('user_id',$user_id)->with(['productPrice'=>function($q){
         $q->select('id','price','admin_price');
     }])->get();
     if($products){
         foreach ($products as $product){
             if($product->productPrice->admin_price!= 0 ){
                 $total_price =  $product->productPrice->admin_price;
             }else{
                 $total_price = $product->productPrice->price;
             }
         }
     }
     return $total_price;
  }
    public function getTotalCart($user_id)
    {
        $data=[];
        $total_price = 0;
        $products = Cart::where('user_id',$user_id)->with(['productPrice'=>function($q){
            $q->select('id','price','admin_price');
        }])->get();
        if($products){
            foreach ($products as $product){
                if($product->productPrice->admin_price!= 0 ){
                    $total_price =  $product->productPrice->admin_price;
                }else{
                    $total_price = $product->productPrice->price;
                }
            }
        }
        $data['total price']=$total_price;
        $data['discount'] = 0;
        return $data;
    }
}
