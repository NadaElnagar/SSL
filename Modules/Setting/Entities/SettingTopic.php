<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingTopic extends Model
{
    protected $table="setting_topic";
    public function setting()
    {
        return $this->hasMany(Setting::class,'setting_data_id','id');
    }

}
