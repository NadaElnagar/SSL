<?php


namespace Modules\HomePage\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\HomePage\Http\Repository\HPRepository;

class HPService extends ResponseService
{
   private $home_page;
   public function __construct()
   {
       $this->home_page = new HPRepository();
   }
   public function index(Request $request)
   {
       $result = $this->home_page->index($request);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
   public function show($id)
   {
       $result = $this->home_page->show($id);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
   public function edit($id,$data)
   {
       $result = $this->home_page->edit($id,$data);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
   public function delete($id)
   {
       $result = $this->home_page->delete($id);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
   public function store($data)
   {
       $result = $this->home_page->store($data);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
   public function getSliderFront($lang)
   {
       $result = $this->home_page->getSliderFront($lang);
       if ($result) {
           return $this->responseWithSuccess($result);
       }
       else {
           return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
       }
   }
}
