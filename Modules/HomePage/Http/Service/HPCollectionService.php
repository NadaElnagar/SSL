<?php


namespace Modules\HomePage\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\HomePage\Http\Repository\HPCollectionRepository;

class HPCollectionService extends ResponseService
{
   private $collection;
   public function __construct()
   {
       $this->collection = new HPCollectionRepository();
   }
    public function index($request)
    {
        $result = $this->collection->index($request);
        if ($result) {
            return $this->responseWithSuccess($result);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function show($id)
    {
        $result = $this->collection->show($id);
        if ($result) {
            return $this->responseWithSuccess($result);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function update($id,$data)
    {
        $result = $this->collection->update($id,$data);
        if ($result) {
            return $this->responseWithSuccess($result);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function delete($id)
    {
        $result = $this->collection->delete($id);
        if ($result) {
            return $this->responseWithSuccess(null);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function store($data)
    {
        $result = $this->collection->store($data);
        if ($result) {
            return $this->responseWithSuccess($result);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function frontListCollection($lang)
    {
        $result = $this->collection->frontListCollection($lang);
        if ($result) {
            return $this->responseWithSuccess($result);
        }
        else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
}
