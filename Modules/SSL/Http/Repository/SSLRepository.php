<?php


namespace Modules\SSL\Http\Repository;


use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\productPrice;

class SSLRepository
{
    protected $categoty;
    protected $brand;
    public function __construct()
    {
        $this->categoty= DB::table('category')->pluck('id')->all();
        $this->brand= DB::table('brand')->get()->pluck('id','name')->all();
    }

    /*This method insert new product and  update old product
    also insert brand name and return id to product*/
    public function allProductFilter($data)
    {
        $result = array();
       // foreach ($data as $product) {
            array_push($result, $this->createOrUpdate($data, $this->brand, $this->categoty));
        //}
        $counts = array_count_values($result);
        if (isset($counts['0'])) return $counts['0']; else return false;
        // return  $counts['1'];
    }

    protected function createOrUpdate($data, $brand, $category)
    {
        $data['api_id'] = $data['Id'];
        // TODO: Implement create() method.
        $product = new Product();
        if (!in_array($data['ProductType'], $category)) {
            $this->insertCategory($data['ProductType']);
        }
        $product_details = Product::firstOrNew(['product_code' => $data['ProductCode']]);
        foreach ($product->getAttributes() as $key=>$field) {
           $product_name =  [change_parameter_lowercase($field)] ;
            $product_details->$product_name = $data[$field];
            $product_details->vendor_name = $this->getVendorName($data['VendorName']);
            unset($product_details[$key]);
        }
        if ($product_details->save()) {
            $product_id = $product_details->id;
            if ($prices = $data['PricingInfo']) {
                foreach ($prices as $price) {
                    $productPrice = productPrice::firstOrNew(['product_id' => $product_id, 'number_of_months' => $price['NumberOfMonths'],
                        'Price' => $price['price']]);
                    $productPrice->product_id;
                    $price['product_id'] = $product_id;
                    foreach ($product->getAttributes() as $key=>$field) {
                       $product_price_name =  change_parameter_lowercase($field);
                        $productPrice->$product_price_name = $price[$field];

                        unset($productPrice[$key]);
                    }
                    $productPrice->save();
                }
                return 1;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }

    public function insertCategory($category)
    {
        $result = DB::table('category')->insertGetId(['name' => $category]);
        $this->categoty = $result;
    }

    protected function getVendorName($vendor)
    {
        if (array_key_exists($vendor, $this->brand)) {
            $vendor_id = $this->brand[$vendor]; // $key = 2;
        } else {
            $vendor_id = DB::table('brand')->insertGetId(['name' => $vendor,'code'=>$vendor]);
            $this->brand[$vendor] = $vendor_id;
        }
        return $vendor_id;
    }


}
