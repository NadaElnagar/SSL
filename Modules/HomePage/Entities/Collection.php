<?php

namespace Modules\HomePage\Entities;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = "collection";
    public function collectionText()
    {
        return $this->hasMany(HPCollection::class);
    }
    public function product()
    {
        return $this->hasMany(CollectionProduct::class,'collection_id','id');
    }
}
