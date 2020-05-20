<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Admin;

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
        if (auth('admin')->check()) {
            return 'admin';
        } else {
            return 'account';
        }
    }

    public function getAuth($login_id, $getGuard = null)
    {
        $guard = '';

        // check with Admin table
        $auth = Admin::query()->where('login_id', $login_id)->first();
        if (empty($auth)) {
            $auth = Account::query()->where('login_id', $login_id)->first();
            if (! empty($auth)) {
                $guard = 'account';
            }
        } else {
            $guard = 'admin';
        }

        return ! empty($getGuard) ? [$auth, $guard] : $auth;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function dataAuthenticated($token)
    {
        $guard = $this->getGuard();

        return [
            'code'         => 200,
            'message'      => 'OK!',
            'typeAuth'     => $guard,
            'data'         => auth($guard)->user(),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }
}
