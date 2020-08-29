<?php


namespace Modules\Setting\Http\Repository;


use Modules\Setting\Entities\Setting;
use Modules\Setting\Entities\SettingTopic;

class SettingFrontRepository
{

    public function settingTopic()
    {
     return   SettingTopic::whereIn('id',function ($query)  {
            $query->select('setting_data_id')
                ->from('setting')
                ->groupBy('setting_data_id');
        })->select('id','topic_name')->get();
    }
    public function setting($data)
    {
        $id   = $data['id'] ;
        $lang = $data['lang'];
        return Setting::where('setting_data_id',$id)->where('lang',$lang)->get();
    }

}
