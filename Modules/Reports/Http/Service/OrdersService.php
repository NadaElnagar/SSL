<?php


namespace Modules\Reports\Http\Service;


use App\Http\Services\ResponseService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Modules\Reports\Http\Repository\OrdersRepository;

class OrdersService extends ResponseService
{
    protected $orders;

    public function __construct()
    {
        $this->orders = new OrdersRepository();
    }

    public function index($request)
    {
        $data = $this->orders->index($request);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }

    /*Export as pdf :Total orders,Payments,Registered customers,Brands,Categories,Products*/
    public function pdf($request)
    {
        $data = $this->orders->index($request);
        $pdf = PDF::loadView('reports::pdf/orders', array('data' => $data,"from"=>$request['from']
        ,'to'=>$request['to']));
        $file = $pdf->download('orders.pdf');
        $data = chunk_split(base64_encode(($file)));
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
