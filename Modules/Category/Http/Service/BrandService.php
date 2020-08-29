<?php


namespace Modules\Category\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\Category\Http\Repository\BrandRepository;

class BrandService extends ResponseService
{

    private $brand;
    public function __construct()
    {
        $this->brand = new BrandRepository();
    }
    public function index()
    {
        $data = $this->brand->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
}
