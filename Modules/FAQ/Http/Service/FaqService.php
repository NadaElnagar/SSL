<?php


namespace Modules\FAQ\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\FAQ\Http\Repository\FaqRepository;

class FaqService extends ResponseService
{
    private $faq ;
    public function __construct()
    {
        $this->faq = new FaqRepository();
    }

    public function index()
    {
        $data = $this->faq->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function store($data)
    {
        $data = $this->faq->store($data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(401,__('messages.Error, Please Try again Letter'));
        }
    }
    public function show($id)
    {
        $data = $this->faq->show($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function destroy($id)
    {
        $data = $this->faq->destroy($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(401,__('messages.Error, Please Try again Letter'));
        }
    }
    public function update($id,$data)
    {
        $data = $this->faq->update($id,$data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(401,__('messages.Error, Please Try again Letter'));
        }
    }
}
