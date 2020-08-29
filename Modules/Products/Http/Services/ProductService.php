<?php


namespace Modules\Products\Http\Services;

use App\Http\Services\ResponseService;
use App\Http\Services\SingletonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use League\Flysystem\Config;
use DB;
use Modules\Products\Http\Repository\ProductRepository;

class ProductService extends ResponseService
{
    private $product;

    public function __construct()
    {
        $this->product =  SingletonService::serviceInstance(ProductRepository::class);

    }

    public function getProductByCategoryID($request)
    {
        $result = $this->product->getProductByCategoryID($request);
        if ($result) {
          return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }

    public function getProductByBrandID($request)
    {
        $result = $this->product->getProductByBrandID($request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }

    public function allProduct($request)
    {
        $result = $this->product->allProduct($request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }

    public function getProductById($id)
    {
        $result = $this->product->show($id);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function approved($request)
    {
        $result = $this->product->approvedList($request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function unapproved($request)
    {

        $result = $this->product->unApprovedList($request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function updateProductStatus($id,$request)
    {
        $admin_id = Auth::user()->id;
        $request['admin_id'] = $admin_id;
        $result = $this->product->updateProductStatus($id,$request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function addNewPriceFromAdmin($id,$request)
    {
        $admin_id = Auth::user()->id;
        $request['admin_id'] = $admin_id;
        $result = $this->product->addNewPriceFromAdmin($id,$request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function getProductPrice($product_id)
    {
        $result = $this->product->getAllPrices($product_id);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
    public function listAllProduct($request)
    {
        $result = $this->product->listAllProduct($request);
        if ($result) {
            return  $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,null);
        }
    }
}
