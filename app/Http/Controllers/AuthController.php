<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\BaseService;
use App\Services\ResponseService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $authService;

    private $responseService;

    private $baseService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     * @param ResponseService $responseService
     * @param BaseService $baseService
     */
    public function __construct(AuthService $authService, ResponseService $responseService, BaseService $baseService) {
        $this->authService = $authService;
        $this->responseService = $responseService;
        $this->baseService = $baseService;
    }

    /**
     * GET: api/auth/login
     * show login form
     */
    public function before_login()
    {
        if (auth()->user()) {
            $success = true;
            $msg = 'OK!';
            $status = 200;
        } else {
            $success = false;
            $msg = 'ERROR!';
            $status = 400;
        }

        return response()->json([
            'success' => $success,
            'message' => $msg,
        ], $status);
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        // authenticate to login
        list($userAuth, $guard) = $this->authService->getAuth($data['email'], true);
        if (! empty($userAuth)) {
            // check password
            if (Hash::check($data['password'], $userAuth->password)) {
                auth($guard)->login($userAuth);

                if ($token = JWTAuth::fromUser($userAuth)) {
                    $accessToken = compact('token');

                    $dataAuth = $this->authService->dataAuthenticated($accessToken['token']);

                    // setup cookie
                    $cookieToken = $this->baseService->setCookie($dataAuth['access_token']);
                    $cookieType = $this->baseService->setCookie($dataAuth['typeAuth'], 'type');

                    return response($dataAuth)->withCookie($cookieToken)->withCookie($cookieType);
                }
            }
        }

        $msg = 'ログインIDまたはログインパスワードが違います。';

        return $this->responseService->json($msg, 400, 400);
    }

    /**
     * Get the authenticated User
     */
    public function user()
    {
        $typeAuth = $this->authService->getGuard();
        $user = auth($typeAuth)->user();

        $extend = ['typeAuth' => $typeAuth];

        return $this->responseService->json('OK!', 200, 200, $user, $extend);
    }

    /**
     * Refresh token the authenticated User
     */
    public function refresh()
    {
        $accessToken = auth()->refresh();
        $dataAuth = $this->authService->dataAuthenticated($accessToken);

        // setup cookie
        $cookieToken = $this->baseService->setCookie($accessToken);
        $cookieType = $this->baseService->setCookie($dataAuth['typeAuth'], 'type');

        return response($dataAuth)->withCookie($cookieToken)->withCookie($cookieType);
    }

    /**
     * @return ResponseFactory|Response
     */
    public function logout()
    {
        auth()->logout(true);

        // remove cookie
        $cookieToken = \Cookie::forget('access_token');
        $cookieType = \Cookie::forget('type');

        $json = ['message' => 'ログアウトしました。'];

        return response($json)->withCookie($cookieToken)->withCookie($cookieType);
    }
}
