<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table ="setting";
    protected $fillable=['title','description','lang','setting_data_id'];
     /**
         * Get the comments for the blog post.
         */
    public function settingTopic()
    {
        return $this->belongsTo(SettingTopic::class,'id','setting_data_id');
    }

}
