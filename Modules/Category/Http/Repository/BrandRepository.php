<?php


namespace Modules\Category\Http\Repository;


use Modules\Category\Entities\Brands;

class BrandRepository
{
    public function index()
    {
        return Brands::get();
    }
}
