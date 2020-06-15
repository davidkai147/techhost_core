<?php


namespace App\Policies;


use App\Enums\Auth\UserType;
use App\Interfaces\AuthInterface;

class BasePolicy
{
    public function before(AuthInterface $user)
    {
        return $user->hasRole(UserType::SUPER_ADMIN);
    }

    public function author(AuthInterface $user, string $permission)
    {
        return $user->hasPermissionTo($permission);
    }
}
