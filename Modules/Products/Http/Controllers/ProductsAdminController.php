<?php


namespace Modules\Products\Http\Controllers;


use App\Http\Requests\pagination;
use App\Http\Services\SingletonService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Products\Http\Requests\AdminPriceRequest;
use Modules\Products\Http\Requests\ProductListAdmin;
use Modules\Products\Http\Requests\UpdateProduct;
use Modules\Products\Http\Services\ProductService;

class ProductsAdminController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service =   SingletonService::serviceInstance(ProductService::class);
    }
    public function approved(pagination $request)
    {
       return  $this->service->approved($request);

    }
    public function unApproved(pagination $request)
    {
        return $this->service->unapproved($request);
    }
    public function updateProductStatus($id,UpdateProduct $request)
    {
        return $this->service->updateProductStatus($id,$request);
    }
    public function addNewPriceFromAdmin($id,AdminPriceRequest $request)
    {
        return $this->service->addNewPriceFromAdmin($id,$request);
    }
    public function getProductPrice($id)
    {
        return $this->service->getProductPrice($id);
    }
    public function listAllProduct(ProductListAdmin $request)
    {
        return $this->service->listAllProduct($request);
    }
}
