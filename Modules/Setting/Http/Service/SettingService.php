<?php


namespace Modules\Setting\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\Setting\Http\Repository\SettingRepository;

class SettingService extends ResponseService
{
    private $setting;
    public function __construct()
    {
        $this->setting = new SettingRepository();
    }
    public function index()
    {
        $data = $this->setting->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function store($data)
    {
        $data = $this->setting->store($data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function show($id)
    {
        $data = $this->setting->show($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function destroy($id)
    {
        $data = $this->setting->destroy($id);
        if ($data) {
            return $this->responseWithSuccess(null);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function update($id,$data)
    {
        $data = $this->setting->update($data,$id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
}
