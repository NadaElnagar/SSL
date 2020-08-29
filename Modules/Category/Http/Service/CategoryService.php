<?php


namespace Modules\Category\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\Category\Http\Repository\CategoryRepository;

class CategoryService extends ResponseService
{
    private $category ;
    public function __construct()
    {
        $this->category = new CategoryRepository();
    }
    public function index()
    {
        $data = $this->category->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function show($id)
    {
        $data = $this->category->show($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function update($id,$data)
    {
        $data = $this->category->update($id,$data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
}
