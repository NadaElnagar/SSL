<?php


namespace App\Http\Services;


use Illuminate\Container\Container;

class SingletonService
{

    public static function serviceInstance($service)
    {
//        $container = new Container();
//        $container->singleton($service);
//        $instance = $container->make($service);

        $instance = app($service);
        return $instance;
    }
}
