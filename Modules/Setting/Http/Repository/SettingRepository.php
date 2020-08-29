<?php

namespace Modules\Setting\Http\Repository;


use Cassandra\Set;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Entities\SettingTopic;

class SettingRepository
{

    public function index()
    {
        return SettingTopic::with('setting')->get();
    }

    public function store($data)
    {
        $seting_topic = $this->saveSettingTopic($data['topic_name']);
        if($seting_topic) {
            $active = $data['active'];
            $details = $data['details'];
            return $this->saveSetting($details,$seting_topic->id,$active);
        }else{
            return false;
        }
    }

    private function saveSettingTopic($topic_name)
    {
        $setting = new SettingTopic();
        $setting->topic_name = $topic_name;
        if($setting->save()) return $setting;
        else return false;
    }
    private function saveSetting($data,$seting_topic_id,$active)
    {
        $details = json_decode(json_encode($data, true));
        for ($count = 0; $count < sizeof($details); $count++) {
            $setting = new Setting();
            $setting->setting_data_id = $seting_topic_id;
            $setting->title = $details[$count]->title;
            $setting->description = $details[$count]->description;
            $setting->lang = $details[$count]->lang;
            $setting->active = $active;
            $setting->save();
        }
        return true;
    }
    public function show($id)
    {
        $setting =  SettingTopic::where('id',$id)->with('setting')->get();
        if ($setting)
            return $setting;
        else return false;
    }

    public function destroy($id)
    {
          Setting::where('setting_data_id', $id)->delete();
           SettingTopic::where('id',$id)->delete();
           return true;
    }

    public function update($data, $id)
    {
        if($data['topic_name']){
            SettingTopic::where('id',$id)->update(['topic_name'=>$data['topic_name']]);
        }
        if($data['details']){
            $setting = Setting::where('setting_data_id', $id)->first();
            $active = $setting->active;
            $setting = Setting::where('setting_data_id', $id)->delete();
            $this->saveSetting($data['details'],$id,$active);
        }
        if($data['active']==0 || $data['active']==1 ){
            Setting::where('setting_data_id', $id)->update(['active'=>$data['active']]);
        }
        return $this->show($id);
    }
}
