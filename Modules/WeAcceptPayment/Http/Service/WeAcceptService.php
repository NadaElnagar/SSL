<?php

namespace Modules\WeAcceptPayment\Http\Service;

use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laminas\Diactoros\Request;
use Modules\Cart\Entities\Cart;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\wallet;
use Modules\SSL\Http\Services\SSLServices;
use Modules\WeAcceptPayment\Http\Repository\WeAcceptRepository;

class WeAcceptService extends ResponseService
{

    public function index($order_id,$price)
    {
        $auth    = $this->authentication();
        $order   = $this->orderCreation($auth,$order_id,$price);
        $payment = $this->paymentKeyGeneration($order,$price);
        return $this->iframeUpload($payment);
    }
    private function authentication()
    {
        $url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $headers = ['Content-Type' => 'application/json'];
//        $username = "nada";
//        $password = "Nada2015@";
        $body = array("username" =>env('we_accept_username'), "password" => env('we_accept_password'));
        try {
            $client = new \GuzzleHttp\Client(['headers' => $headers]);
            $request = $client->post($url, ["body" => json_encode($body)]);
            return $request->getBody()->getContents();
            //  return $this->responseWithSuccess($data);
        } catch (HttpException $ex) {
            return $ex;
        }
    }

    private function orderCreation($auth,$order_id,$price)
    {
        $data = Json_decode($auth, true);
        $token = $data['token'];
        $merchant_id = $data['profile']['id'];
        $url = 'https://accept.paymobsolutions.com/api/ecommerce/orders?token=' . $token;
        $headers = ['Content-Type' => 'application/json'];
        $body =
            array(
                "delivery_needed" => "false",
                "merchant_id" => $merchant_id,
                "merchant_order_id" => $order_id,
                "amount_cents" => $price*100,
                "currency" => "EGP",
                "items" => [],
            );
        try {
            $client = new \GuzzleHttp\Client(['headers' => $headers]);
            $request = $client->post($url, ["body" => json_encode($body)]);
            $result['token'] = $token;
            $result['order'] = $request->getBody()->getContents();

            return $result;
            //  return $this->responseWithSuccess($data);
        } catch (HttpException $ex) {
            return 'Error';
        }
    }

    private function paymentKeyGeneration($order,$price)
    {
        $data = Json_decode($order['order'], true);
        $token = $order['token'];
        $url = 'https://accept.paymobsolutions.com/api/acceptance/payment_keys?token=' . $token;
        $headers = ['Content-Type' => 'application/json'];
        $body = array(
            "amount_cents" => $price*100,
            "currency" => "EGP",
            "card_integration_id" => env('we_accept_card_integration_id'),
            "order_id" => $data['id'],
            "billing_data" => array(
                "email" => Auth::user()->email,
                "apartment" => "N/A",
                "floor" => "N/A",
                "first_name" => "N/A",
                "street" => "N/A",
                "building" => "N/A",
                "phone_number" => "N/A",
                "shipping_method" => "N/A",
                "postal_code" => "N/A",
                "city" => "N/A",
                "country" => "N/A",
                "last_name" => "N/A",
                "state" => "N/A",
            )
        );
        try {
            $client = new \GuzzleHttp\Client(['headers' => $headers]);
            $request = $client->post($url, ["body" => json_encode($body)]);
            return $request->getBody()->getContents();
            //  return $this->responseWithSuccess($data);
        } catch (HttpException $ex) {
            return 'Error';
        }
    }

    private function iframeUpload($payment)
    {
        $url='';
        $token = Json_decode($payment, true);
        if ($token) {
            $iframe_id = env('we_accept_iframe');
            $url = 'https://accept.paymobsolutions.com/api/acceptance/iframes/' . $iframe_id . '?payment_token=' . $token['token'];
            return $url;
        } else {
            return $url;
        }
    }

    public function callBack($request)
    {

        (new WeAcceptRepository())->logPayment($request);
        if ($request->has('success') && $request->has('order')) {
            $we_Accept_order_id = $request['order'];
            $order_id = $request['merchant_order_id'];
            $amount_cents = $request->amount_cents / 100;
            $validate_hmac = $this->validateCallbackHmac($request);
            if($validate_hmac){
                return $this->processCheckout($order_id,$we_Accept_order_id);
            }else{
               return returnHtmlResponse('Sorry we were unable to complete the checkout process .. Please try again later','false');
             }
        }else{
            return returnHtmlResponse('Sorry we were unable to complete the checkout process .. Please try again later','false');
        }
    }

    private function processCheckout($order_id,$we_Accept_order_id)
    {
        $order = Order::find($order_id);
        $data = array('order_id'=>$order_id,'we_Accept_order_id'=>$we_Accept_order_id
        ,'user_id'=>$order_id->user_id,"total_price"=>$order->total_price);
        (new WeAcceptRepository())->wallet($data);
        $order_items =  Cart::where('user_id',$order->user_id)->get();
        $check_out = (new SSLServices())->callBackWeAccept($order_id,$order_items);
        if($check_out == 1)
        {
            return returnHtmlResponse(__('message.Please Check Your Orders To Complete Process'),'True');
        }else{
            return returnHtmlResponse('we found some issue in buy some order, please check your cart','false');
        }
    }

    private function validateCallbackHmac($request)
    {
        // hmac secret key
        $secret_key = config('global.weaccept_secret_key');

        // needed key for hashing in alphabetically sorted keys
        $required_params = ['amount_cents', 'created_at', 'currency', 'error_occured', 'has_parent_transaction', 'id',
            'integration_id', 'is_3d_secure', 'is_auth', 'is_capture', 'is_refunded', 'is_standalone_payment', 'is_voided', 'order',
            'owner', 'pending', 'source_data_pan', 'source_data_sub_type', 'source_data_type', 'success',
        ];

        $concated_string = '';
        $hashed_hmac = $request->hmac;
        foreach ($required_params as $param) {
            $concated_string .= $request->has($param) ? $request[$param] : '';
        }

        // start hashing the string
        $hashed_string = hash_hmac('sha512', $concated_string, $secret_key);
        // validate both hashed hmacs are equal using md5
        if (md5($hashed_string) === md5($hashed_hmac)) {
            return true;
        } else {
            return false;
        }

    }
}
