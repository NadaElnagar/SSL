<?php


namespace Modules\Reports\Http\Service;


use App\Http\Services\ResponseService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Modules\Reports\Http\Repository\CustomersRepository;

class CustomersService extends ResponseService
{
    private $customer;
    public function __construct()
    {
        $this->customer = new CustomersRepository();
    }
    public function index()
    {
        $customer =  $this->customer->index();
         if ($customer) {
            return $this->responseWithSuccess( $customer);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
    public function pdf()
    {
        $customer =  $this->customer->index();
        $pdf = PDF::loadView('reports::pdf/customers',  array('data' => $customer));
        $file = $pdf->download('customers.pdf');
        $data=  chunk_split(base64_encode(($file)));
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
