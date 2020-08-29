<?php


namespace Modules\Reports\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\Reports\Http\Repository\DashboardRepository;
use Barryvdh\DomPDF\Facade as PDF;

class DashboardService extends ResponseService
{
    private $dashboard;

    public function __construct()
    {
        $this->dashboard = new DashboardRepository();
    }

    /*Total orders,Payments,Registered customers,Brands,Categories,Products*/
    public function dashboard()
    {
        $data = $this->dashboard->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
    /*Export as pdf :Total orders,Payments,Registered customers,Brands,Categories,Products*/
    public function pdf()
    {
        $data = $this->dashboard->index();
        $pdf = PDF::loadView('reports::pdf/dashboard',  array('data' => $data));
        $file = $pdf->download('dashboard.pdf');
        $data=  chunk_split(base64_encode(($file)));
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
