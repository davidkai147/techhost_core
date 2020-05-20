<?php

namespace App\Traits;

trait AccountTrait
{
    /**
     * @param $login_pw
     * @return string
     */
    public function hashPassword($login_pw)
    {
        return bcrypt($login_pw);
    }
}
