<?php


namespace Modules\Reports\Http\Service;


use App\Http\Services\ResponseService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Modules\Reports\Http\Repository\CertificatesSellingRepository;

class CertificatesSellingService extends ResponseService
{
    private $certificate;

    public function __construct()
    {
        $this->certificate = new CertificatesSellingRepository();
    }

    public function index()
    {
        $data =  $this->certificate->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
    public function pdf()
    {
        $data =  $this->certificate->index();
        $pdf = PDF::loadView('reports::pdf/certificate',  array('data' => $data));
        $file = $pdf->download('certificate.pdf');
        $data=  chunk_split(base64_encode(($file)));
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
