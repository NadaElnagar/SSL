<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{

    public function storeCasheRedis($cache_name, $result)
    {
        if(count($result)>0){
            $redis = Redis::Connection();
            Cache::store('redis')->put($cache_name, $result, Carbon::now()->addDays(1));
            return Cache::store('redis')->get($cache_name);
        }else{
            return $result;
        }
    }
    public function getCasheRedis($cache_name)
    {
        if ($result = Cache::store('redis')->get($cache_name)) return $result;
        else return false;
    }
    public function destroyAllCashe()
    {
        Cache::store('redis')->clear();
    }

}
