<?php


namespace Modules\Category\Http\Controllers;


use Modules\Category\Http\Service\BrandService;

class BrandControllerAdmin
{

    private $brand ;
    public function __construct()
    {
        $this->brand =  new BrandService();
    }
    public function index()
    {
        return $this->brand->index();
    }
}
