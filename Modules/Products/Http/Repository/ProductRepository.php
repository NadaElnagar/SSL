<?php


namespace Modules\Products\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Http\Requests\pagination;
use App\Http\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\productPrice;
use Modules\Products\Entities\Product;

class ProductRepository
{
    protected $cache_service;

    public function __construct()
    {
        $this->cache_service = new CacheService();
    }

    private function name_cache($name,$request)
    {
        $limit = $request['limit'];
        $offset = $request['offset'];
        if(isset($request['id']) && $request['id']){
            return  $cache_name = $name.$offset.'_'.$limit.'_'.$request['id'];
        }else{
            return  $cache_name = $name.$offset.'_'.$limit;
        }
    }
    public function getProductByCategoryID($request)
    {
        $category_id = $request['id'];
        $cache_name = $this->name_cache('ssl_category_'.$category_id,$request);
        // TODO: Implement getProductByCategoryID() method.
        if ($result = $this->cache_service->getCasheRedis($cache_name)) {
            return $result;
        } else {
            $product = Product::where('active', 1);
           if(isset($category_id)) $product->where('product_type', $category_id);
            $product_repository = (new BaseRepository())->paginationRepository($request,$product);
            $result['count'] = $product_repository['count'];
            $result['data'] = $this->getProducts($product_repository['data']);
             return $this->cache_service->storeCasheRedis($cache_name, $result);
        }
    }

    public function getProductByBrandID($request)
    {
        $id = $request['id'];
        $cache_name = $this->name_cache('ssl_brand_',$request);
        if ($result = $this->cache_service->getCasheRedis($cache_name)) {
            return $result;
        } else {
            $product = Product::where('active', 1)->where('vendor_name', $id);

            $product_repository = (new BaseRepository())->paginationRepository($request,$product);
            $result['count'] = $product_repository['count'];
            $result['data'] = $this->getProducts($product_repository['data']);
            return $this->cache_service->storeCasheRedis($cache_name, $result);
        }
    }

    public function allProduct($request)
    {
        $product = Product::where('active', 1);
        $products = (new BaseRepository())->paginationRepository($request,$product);
        $result =  $this->getProducts($products['data']);
        $result = array('count' => $products['count'], 'product' => $result);
        return $result;
    }

    public function show($id)
    {
        $cache_name = 'product_' . $id;
        if ($result = $this->cache_service->getCasheRedis($cache_name)) {
            return $result;
        } else {
            $product = DB::table('product')->where('product.id', $id)->where('active',1)->get();
           if($product) {$result = $this->getProducts($product);
            return $this->cache_service->storeCasheRedis($cache_name, $result);}
           else{
               return false;
           }
        }
    }

    public function getProducts($products)
    {
        if (count($products) > 0) {
            foreach ($products as $product) {
                $prices = $this->getPricesFrontEnd($product->id);
                $product->prices = $prices;
                $result[] = $product;
            }
            return $result;
        } else {
            return $products;
        }
    }
    public function getPricesFrontEnd($product_id)
    {
        $prices =  DB::table('product_price')->where('product_id', $product_id)->get();
        if($prices) {
            foreach ($prices as $price) {
                if($price->admin_price !=0){
                    $price->price = $price->admin_price;
                }

            }
        }
        return $prices;
    }
    public function getAllPrices($product_id)
    {
        return DB::table('product_price')->where('product_id', $product_id)->get();
    }


    public function approvedList($request)
    {
        $product = Product::where('active', 1);
        $products = (new BaseRepository())->paginationRepository($request,$product);
        $result = array('count' => $products['count'], 'product' => $products['data']);
        return $result;
    }

    public function unApprovedList($request)
    {
        $limit = $request['limit'];
        $offset = $request['offset'] * $limit;
        $count = Product::where('active', 0)->count();
        if (isset($limit) && isset($offset)) {
            $product = Product::where('active', 0)->offset($offset)->limit($limit)->get();
        } else {
            $product = Product::where('active', 0)->get();
        }
        $result = array('count' => $count, 'product' => $product);
        return $result;
    }

    /*Change active Record according send from front end 1=active, 0= not active*/
    public function updateProductStatus($id, $request)
    {
        return Product::where('id', $id)->update(['active' => $request['active'], 'admin_id' => $request['admin_id']]);
    }

    /*admin can ovveride price in price */
    public function addNewPriceFromAdmin($id, $request)
    {
        return productPrice::where('id', $id)->update(['admin_price' => $request['admin_price'],
            'admin_id' => $request['admin_id']
        ]);
    }

    public function listAllProduct($request)
    {
        $brand    = $request['brand'];
        $category = $request['category'];
        $active   = $request['active'];
        $product  = (new Product())->newQuery();
        if (isset($active)) $product->where('active', 0);
        if (isset($category)) $product->where('product_type', $category);
        if (isset($brand)) $product->where('vendor_name', $brand);
        $products = (new BaseRepository())->paginationRepository($request,$product);
        $result = array('count' => $products['count'], 'product' => $products['data']);
        return $result;
    }
}
