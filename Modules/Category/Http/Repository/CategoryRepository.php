<?php


namespace Modules\Category\Http\Repository;


use Modules\Category\Entities\Category;

class CategoryRepository
{

    public function index()
    {
        return Category::get();
    }
    public function show($id)
    {
        return Category::find($id);
    }
    public function update($id,$data)
    {
        $category = Category::find($id);
        $category->name = $data['name'];
        if($category->update()){
            return true;
        }else{
            return false;
        }
    }
}
