<?php


namespace App\Enums\Auth;


use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    public const SUPER_ADMIN = 'super-admin';
    public const ADMIN = 'admin';
    public const USER = 'user';
}
