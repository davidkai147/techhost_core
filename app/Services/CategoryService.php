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

    public function index(Category $category)
    {
        return $this->read($category);
    }


}
