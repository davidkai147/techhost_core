<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;

class CheckAdmin
{
    protected $responseService;
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->is_admin())
            return $next($request);
        else
            return $this->responseService->render_not_allow_access();
    }

    private

    function is_admin()
    {
        return auth('admin')->check();
    }
}
