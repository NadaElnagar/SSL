<?php


namespace Modules\Cart\Http\Controllers;

use App\Http\Services\SingletonService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Http\Requests\CartValidation;
use Modules\Cart\Http\Services\CartServices;

class CartControllerApi extends Controller
{
    private $cart;
    public function __construct()
    {
        $this->cart = SingletonService::serviceInstance(CartServices::class);
    }
    public function addToCart(CartValidation $request)
    {
       return $this->cart->addToCart(Auth::user()->id,$request);
    }
    public function userCart()
    {
        return $this->cart->userCart(Auth::user()->id);
    }
    public function userCartCount()
    {
        return $this->cart->userCartCount(Auth::user()->id);
    }
    public function Calculation()
    {
        return $this->cart->Calculation(Auth::user()->id);

    }
}
