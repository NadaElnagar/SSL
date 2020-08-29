<?php


namespace Modules\WeAcceptPayment\Http\Controllers;


use Laminas\Diactoros\Request;
use Modules\WeAcceptPayment\Http\Service\WeAcceptService;

class WeAcceptFrontController
{

    private  $accept;
    public function __construct()
    {
        $this->accept = new WeAcceptService();
    }
//    public function index()
//    {
//        return $this->accept->iframeUpload();
//    }
//    public function callBack(Request $request)
//    {
//        return $this->accept->callBack($request);
//    }
}
