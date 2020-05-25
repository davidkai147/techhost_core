<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\CRUDTrait;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiBaseController
{
    protected $categoryService;
    public function __construct(Request $request, CategoryService $categoryService)
    {
        parent::__construct($request);
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Category $category, Request $request)
    {
        //$category = Category::where('id', 10000);
        //$category = $this->categoryService->index($category);
        //$category = Category::with(['parent', 'allChildren'])->whereNull('parent_id');
        // dd($category->get());

        $category = $category->with(["parent.allChildren" => function($query) {
            $query->whereNull('parent_id');
        }]);

        dd($category->get());
        //$category = $category->paginate($this->perPage);
        return $this->ok($category, CategoryTransformer::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
