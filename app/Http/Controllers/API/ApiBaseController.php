<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBaseController extends Controller
{
    use HttpResponse;

    /** @var object|null $user */
    protected $user = null;

    /**@var string|null $perPage */
    protected $perPage = null;

    /**@var string|null $orderBy */
    protected $orderBy = null;

    /**@var string|null $direction */
    protected $direction = null;

    /**
     * ApiBaseController constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param $orderByDefault
     */
    public function __construct(Request $request, $orderByDefault = null)
    {
        $this->perPage = $request->get('perPage') ? $request->get('perPage') : 9999;
        $this->orderBy = $request->get('orderBy') ? $this->getOrderBy($request) : (! empty($orderByDefault) ? $orderByDefault : $this->latest_at());
        $this->direction = $request->get('direction') ? $request->get('direction') : 'desc';

        $authService = new AuthService();
        $this->user = optional(auth($authService->getGuard())->user());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    private function getOrderBy($request)
    {
        if ($request->get('orderBy') == 'latest_at') {
            return $this->latest_at();
        } else {
            return $request->get('orderBy');
        }
    }

    /**
     * @return string
     */
    private function latest_at()
    {
        return 'GREATEST(created_at,updated_at)';
    }
}
