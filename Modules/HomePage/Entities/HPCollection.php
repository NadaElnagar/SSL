<?php

namespace Modules\HomePage\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Product;

class HPCollection extends Model
{
    protected $table = "hp_collection";
    protected $appends = array('language');
    public function getLanguageAttribute()
    {
        if($this->lang == 1 )
        {
            return "en";
        }elseif($this->lang == 2){
            return "ar";
        }
    }
    public function product()
    {
        return $this->hasMany(CollectionProduct::class,'collection_id','collection_id');
    }
}
