<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ResponseService;
use App\Traits\CRUDTrait;
use App\Transformers\CategoryTransformer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends ApiBaseController
{
    protected $categoryService;
    private $responseService;
    public function __construct(Request $request, CategoryService $categoryService, ResponseService $responseService)
    {
        parent::__construct($request);
        $this->categoryService = $categoryService;
        $this->responseService = $responseService;
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
        // Day la code tay
        //$category = $category->with("allChildren")->whereNull('parent_id');
        $category = $this->categoryService->getPaginate($category);
        $category = $category->paginate($this->perPage);
        return $this->ok($category, CategoryTransformer::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return ResponseFactory|Response
     */
    public function store(CategoryRequest $request)
    {
        $content = Category::query()->create($request->all());
        $msg = 'Insert ok';
        return $this->responseService->json($msg, 200, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param int $id
     * @return JsonResponse
     */
    public function show(Category $category)
    {
        //$category = $this->categoryService->get($category);
        return $this->ok($category, CategoryTransformer::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
