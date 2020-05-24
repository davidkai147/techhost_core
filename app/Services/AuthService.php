<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Admin;
use App\Models\User;

class AuthService
{
    /**
     * AuthService constructor.
     */
    public function __construct()
    {
    }

    public function getGuard()
    {
        if (auth(config('techhost.guard.sa'))->check()) {
            return config('techhost.guard.sa');
        } else if (auth(config('techhost.guard.ad'))->check()) {
            return config('techhost.guard.ad');
        }
        return config('techhost.guard.user');
    }

    public function getAuth($email, $getGuard = null)
    {
        $guard = 'web';

        // check with Admin table
        $auth = User::query()->where('email', $email)->first();
        if (!empty($auth)) {
            switch ($auth->type) {
                case config('techhost.user_type.sa') :
                    $guard = config('techhost.guard.sa');
                    break;
                case config('techhost.user_type.ad') :
                    $guard = config('techhost.guard.ad');
                    break;
            }
        }

        return !empty($getGuard) ? [$auth, $guard] : $auth;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function dataAuthenticated($token)
    {
        $guard = $this->getGuard();
        $type = auth($guard)->user()->type;
        return [
            'code' => 200,
            'message' => 'OK!',
            'typeAuth' => $type,
            'data' => auth($guard)->user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }
}
