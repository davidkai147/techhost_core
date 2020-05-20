<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccount
{
    protected $responseService;
    protected $auth;
    public function __construct(ResponseService $responseService, Auth $auth)
    {
        $this->responseService = $responseService;
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->is_account())
            return $next($request);
        else
            return $this->responseService->render_not_allow_access();
    }

    private

    function is_account()
    {
        return auth('account')->check();
    }
}
