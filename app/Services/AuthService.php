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
//        if (auth('admin')->check()) {
//            return 'admin';
//        } else {
//            return 'account';
//        }
        return 'web';
    }

    public function getAuth($email, $getGuard = null)
    {
        $guard = '';

        // check with Admin table
        $auth = User::query()->where('email', $email)->first();
//        if (empty($auth)) {
//            $auth = Account::query()->where('login_id', $login_id)->first();
//            if (! empty($auth)) {
//                $guard = 'account';
//            }
//        } else {
//            $guard = 'admin';
//        }
        $guard = 'web';

        return ! empty($getGuard) ? [$auth, $guard] : $auth;
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
            'code'         => 200,
            'message'      => 'OK!',
            'typeAuth'     => $type,
            'data'         => auth($guard)->user(),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }
}
