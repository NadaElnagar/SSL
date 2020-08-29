<?php


namespace Modules\SSL\Http\Services;


use App\Http\Services\CacheService;
use App\Http\Services\ResponseService;
use App\Http\Services\SingletonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Http\Repository\CartRepository;
use Modules\Order\Http\Repository\OrderRepository;
use Modules\SSL\Http\Repository\SSLRepository;
use Modules\WeAcceptPayment\Http\Service\WeAcceptService;

class SSLServices extends ResponseService
{
    private $ssl,$order,$cart;
    protected $partner_code;
    protected $auth_token;
    protected $url;
    public function __construct()
    {
        $this->ssl =   SingletonService::serviceInstance( SSLRepository::class);
        $this->order = SingletonService::serviceInstance(OrderRepository::class);
        $this->cart  = SingletonService::serviceInstance(CartRepository::class);
        $this->partner_code = env('thesslstore_partner_key');
        $this->auth_token = env('thesslstore_token');
        $this->url = env('thesslstore_url');
    }

    public function fetchDataSSL()
    {
        $url = $this->url . '/product/query';
        $headers = ['Content-Type' => 'application/json', 'charset' => 'utf-8'];
        $data = ["AuthRequest" => [
            "PartnerCode" => $this->partner_code,
            "AuthToken" => $this->auth_token
        ],
            "ProductType" => 0,
            "NeedSortedList" => true
        ];
        $client = new \GuzzleHttp\Client(['headers' => $headers]);
        $request = $client->post($url, ["body" => json_encode($data)]);
        if ($request) {
            $response = $request->getBody()->getContents();
//        $response = array('CanbeReissued'=>'1',
//            'CurrencyCode'=>'USD', 'IsCompetitiveUpgradeSupported'=>'1', 'IsSanEnable'=>'0',
//            'IsCompetitiveUpgradeSupported'=>'', 'IsSanEnable'=>'',
//            'IsSupportAutoInstall'=>'1', 'IssuanceTime'=>'Minutes', 'MaxSan'=>'0',
//            'MinSan'=>'0','ProductDescription'=>'A standard, yet popular Domain Validated (DV) certificate due to its low cost and rapid issuance process. With 99% of browser recognition and its encryption strength of 256-bit, it’s an ideal solution for protecting a single, entry-level site.',
//            'ProductName'=>'RapidSSL Certificate', 'ProductSlug'=>'https://sslfeatures.com/rapidssl-certificate.html', 'ProductType'=>'1',
//            'ReissueDays'=>'7', 'SiteSeal'=>'Static', 'VendorName'=>'RAPIDSSL',
//            'Warranty'=>'10000', 'isCodeSigning'=>'1', 'isCodeSigning'=>'0',
//            'isDVProduct'=>'1', 'isEVProduct'=>'0', 'isGreenBar'=>'0',
//            'isMalwareScan'=>'0', 'isMobileFriendly'=>'1', 'isNoOfServerFree'=>'1',
//            'isOVProduct'=>'0', 'isScanProduct'=>'0', 'isSealInSearch'=>'0',
//            'isVulnerabilityAssessment'=>'0', 'isWildcard'=>'0', 'Id'=>'5' , 'ProductCode'=>'redia'
//        );
            return $this->SaveORUpdateProducts($response);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    protected function SaveORUpdateProducts($data)
    {
        $allProducts = Json_decode($data, true);
        $result = $this->ssl->allProductFilter($allProducts);
        if ($result) {
            (new CacheService())->destroyAllCashe();
            $counts = array_count_values($result);
            if (isset($counts['false'])) $data = __("messages.Number of Fails ") . $counts['false']; else $data='';
             $data .=__("messages.redirect to Order details page to Complete some Process");
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function InviteOrder($user_id)
    {
        $total_price = (new CartRepository())->getTotalPrice($user_id);
        if ($total_price > 0) {
            $newOrder = $this->order->SaveNewOrder($user_id, $total_price);
            if ($newOrder) {
                $order_id = $newOrder->id;
                $we_Accept = new WeAcceptService();
                $result = $we_Accept->index($order_id, $total_price);
                return $this->responseWithSuccess($result);
            } else {
                return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
            }
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Cart is Empty'));
        }
    }

    public function callBackWeAccept($order_id,$order_items)
    {
        $result =  $this->orderDetails($order_id,$order_items);
        $cart_result = $this->orderResult($result);
        if($cart_result == 1 ){
            return true;
        }else{
            return false;
        }
    }
    public function orderDetails($order_id, $order_items)
    {
        if ($order_items) {
            $result =array();
            foreach (json_decode($order_items) as $order_item) {
                for ($counter = 1; $counter <= $order_item->quantity; $counter++) {
                    $product = $this->getProductDetailsByPriceID($order_item->price_id);
                    $request = $this->accessInviteLinkCurl($product);
                    if ($request) {
                        $price_respons = Json_decode($request, true);
                        $price = $this->getPricePurchase($product);
                        $order_status = $this->order->SaveOrderItems($order_id, $order_item->price_id, $price, $price_respons);
                        if ($order_status)
                            $result[]= true;
                        else $result[] = $order_item->price_id;
                    } else {$result = false;}
                }
            }
            return $result;
        } else {
            $this->order->deleteOrder($order_id);
            return false;
        }
    }

    protected function getProductDetailsByPriceID($id)
    {
        return $this->order->getProductDetailsByPriceID($id);
    }

    protected function accessInviteLinkCurl($data)
    {
        $url = $this->url . '/order/inviteorder';
        $headers = ['Content-Type' => 'application/json', 'charset' => 'utf-8'];
        $data = ["AuthRequest" => [
            "PartnerCode" => $this->partner_code,
            "AuthToken" => $this->auth_token
        ],
            "ExtraSAN" => 0,
            "RequestorEmail" => Auth::user()->email,
            "PreferVendorLink" => true,
            "ProductCode" => $data->ProductCode,
            "ServerCount" => $data->NumberOfServer,
            "ValidityPeriod" => $data->NumberOfMonths
        ];
        $client = new \GuzzleHttp\Client(['headers' => $headers]);
        $request = $client->post($url, ["body" => json_encode($data)]);
        if ($request) {
            return $response = $request->getBody()->getContents();
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    protected function getPricePurchase($data)
    {
        if ($data->admin_price == 0) {
            return $data->Price;
        } else {
            return $data->admin_price;
        }
    }

    protected function orderResult($result )
    {
        $user_id = Auth::user()->id;
        $price_id= array();
        if($result){
            foreach ($result as $item) {
                if ($item != true) {
                    echo $item;
                   $price_id []=$item;
                }
            }
            if(sizeof($price_id)>0)
            {
                $cart_result = $this->cart->updateUserCart($price_id,$user_id);
            }else{
                $cart_result = $this->cart->emptyUserCart($user_id);
            }
            return $cart_result;
        }
        else{
            return false;
        }
    }

    public function order_status($order_item_id)
    {
      if($status= $this->orderStatusSsl($order_item_id->TheSSLStoreOrderID))
      {
          $order = Json_decode($status, true);
          return   $this->order->orderTransaction($order,$order_item_id->id,$order_item_id->status);
      }else{
          return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
      }
    }
    protected function orderStatusSsl($TheSSLStoreOrderID)
    {
        $url = $this->url . '/order/status';
        $headers = ['Content-Type' => 'application/json', 'charset' => 'utf-8'];
        $data = ["AuthRequest" => [
            "PartnerCode" => $this->partner_code,
            "AuthToken" => $this->auth_token
        ],
            "TheSSLStoreOrderID"=>$TheSSLStoreOrderID
        ];
        $client = new \GuzzleHttp\Client(['headers' => $headers]);
        $request = $client->post($url, ["body" => json_encode($data)]);
        if ($request) {
            return $response = $request->getBody()->getContents();
        } else {
            return false;
        }
    }
}
