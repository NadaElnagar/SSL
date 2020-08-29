<?php


namespace Modules\Setting\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Modules\Setting\Http\Repository\SettingFrontRepository;

class SettingFrontService extends ResponseService
{

    private $setting;
    public function __construct()
    {
        $this->setting = new SettingFrontRepository();
    }

    public function settingTopic()
    {
        $result = $this->setting->settingTopic();
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
    public function setting($data)
    {
        $result = $this->setting->setting($data);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST,__('messages.Error, Please Try again Letter'));
        }
    }
}
