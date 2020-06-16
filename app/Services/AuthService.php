<?php

namespace App\Services;

use Carbon\Carbon;
use Flugg\Responder\Exceptions\Http\UnauthenticatedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthService extends UnauthenticatedException
{
    protected $errorCode;

    /**
     * @param array $credentials
     * @param string|null $guard
     * @return array
     */
    public function executeLogin(array $credentials, string $guard = null): array
    {
        if (!$token = jwt_guard($guard)->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ])) {
            $message = new UnauthenticatedException(trans('auth.failed'));
            $message->errorCode = '401';
            throw $message;
        }
        if (jwt_guard($guard)->user()->is_deleted){
            $message = new UnauthenticatedException(trans('auth.failed'));
            $message->errorCode = '401';
            throw $message;
        }
        jwt_guard($guard)->setToken($token);
        return [
            'token' => $token,
            'exp' => Carbon::parse(jwt_guard($guard)->getPayload()->get('exp'))
        ];
    }

    public function executeRefreshToken(string $guard = null)
    {
        try {
            $token = jwt_guard($guard)->refresh(true);
            jwt_guard($guard)->setToken($token);
        } catch (TokenExpiredException $exception) {
            throw new BadRequestHttpException('Token Expired');
        } catch (TokenInvalidException $exception) {
            throw new BadRequestHttpException('Token Invalid');
        }
        return [
            'token' => $token,
            'exp' => Carbon::parse(
                jwt_guard($guard)->getPayload()->get('exp')
            )
        ];
    }
}
