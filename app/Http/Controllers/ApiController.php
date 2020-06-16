<?php

namespace App\Http\Controllers;

use App\Traits\HasTransformer;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    use HasTransformer;

    protected $perPage;

    const limitPerPage = 100;

    public function __construct(Request $request)
    {
        $this->perPage = $request->get('perPage') ? $this->getPerPage($request->get('perPage')) : 15;
    }

    private function getPerPage($perPage)
    {
        return $perPage > ApiController::limitPerPage ? ApiController::limitPerPage : $perPage;
    }
}
