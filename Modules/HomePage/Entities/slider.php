<?php

namespace Modules\HomePage\Entities;

use Illuminate\Database\Eloquent\Model;

class slider extends Model
{
    protected $table = "slider";
    protected $appends = array('image_url');
    public function text($lang = null)
    {
       return $this->hasMany(SliderText::class,'slider_id','id');

    }
    public function getImageUrlAttribute()
    {
        return asset('/public/storage/slider/'.$this->image);
    }

}
