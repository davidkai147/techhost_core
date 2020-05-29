<?php


namespace App\Services;


use App\Models\Category;
use App\Traits\CRUDTrait;

class CategoryService extends BaseService
{
    use CRUDTrait;

    public function __construct()
    {

    }

    public function getPaginate(Category $category)
    {
        $category = $category->with('allChildren','created_user','updated_user')->whereNull('parent_id');
        return $category;
    }


}
