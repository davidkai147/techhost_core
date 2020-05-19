<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $responseService;

    /**
     * HomeController constructor.
     *
     * @param \App\Services\ResponseService $responseService
     */
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function app()
    {
        return view('app');
    }

    public function redirect(Request $request)
    {
        return redirect("/cms/{$request->getPathInfo()}");
    }

    public function redirectSignIn()
    {
        return redirect("/cms/signin");
    }

    /**
     * unauthenticated json
     */
    public function unauthenticated()
    {
        return $this->responseService->unauthenticated();
    }
}
