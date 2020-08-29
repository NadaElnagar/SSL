<?php


namespace Modules\Setting\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Http\Requests\SettingFrontRequest;
use Modules\Setting\Http\Service\SettingFrontService;

class SettingFrontController extends Controller
{

    private $setting;
    public function __construct()
    {
        $this->setting = new SettingFrontService();
    }
    public function settingTopic()
    {
        return $this->setting->settingTopic();
    }
    public function setting(SettingFrontRequest $request)
    {
        $header = $request->header('Accept-Language');
        if($header) $request['lang'] = $header; else  $request['lang'] = 'en';
        return $this->setting->setting($request);
    }
}
