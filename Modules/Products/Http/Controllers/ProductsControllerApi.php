<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Requests\pagination;
use App\Http\Services\SingletonService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Http\Repository\ProductRepository;
use Modules\Products\Http\Services\ProductService;
class ProductsControllerApi extends Controller
{
    private $services;
    public function __construct()
    {
        $this->services =   SingletonService::serviceInstance(ProductService::class);

    }

    public function getProductByCategoryID(pagination $request)
    {
        return $this->services->getProductByCategoryID($request);
    }
    public function getProductByBrandID(pagination $request)
    {
        return $this->services->getProductByBrandID($request);
    }

    public function allAprovedProduct(pagination $request)
    {
        return $this->services->allProduct($request);
    }
    public function getProductById($id)
    {
        return $this->services->getProductById($id);
    }
    public function getProductDetailsByPriceID($price_id)
    {
        return $this->services->getProductDetailsByPriceID($price_id);
    }
}
