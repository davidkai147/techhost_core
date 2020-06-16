<?php


namespace App\Http\Controllers;

use App\Enums\Auth\GuardType;
use App\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Flugg\Responder\Exceptions\Http\PageNotFoundException;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
use Flugg\Responder\Serializers\NoopSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    protected $guard;
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:admin,user')->except('login', 'refresh');
    }

    /**
     * @param Request $request
     */
    private function checkGuard(Request $request)
    {
        $this->guard = $request->route('guard');
        if (!in_array($this->guard, GuardType::getValues())) {
            throw new PageNotFoundException();
        }
    }

    /**
     * @param LoginRequest $request
     * @return SuccessResponseBuilder|JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $this->checkGuard($request);
        $credentials = $request->validated();
        $result = $this->authService->executeLogin($credentials, $this->guard);
        return $this->setSerializer(NoopSerializer::class)->httpCreated($result);
    }


    /**
     * @param Request $request
     * @return SuccessResponseBuilder|JsonResponse
     */
    public function logout(Request $request)
    {
        $this->checkGuard($request);
        jwt_guard($this->guard)->logout(true);
        return $this->httpNoContent();
    }

    /**
     * @param Request $request
     * @return SuccessResponseBuilder|JsonResponse
     */
    public function refresh(Request $request)
    {
        $this->checkGuard($request);
        $result = $this->authService->executeRefreshToken($this->guard);
        return $this->setSerializer(NoopSerializer::class)->httpCreated($result);
    }
}
