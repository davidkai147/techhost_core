<?php

namespace App\Models;

use App\Traits\ModifyTrait;
use App\Traits\UuidTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //use UuidTrait;
    use ModifyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['tpe' => 'web'];
    }

    /**
     * Create latest_at column
     *
     * @return string
     */
    public function getLatestAtAttribute()
    {
        $latest_at = $this->created_at >= $this->updated_at ? $this->created_at : $this->updated_at;

        return Date('Y-m-d H:i:s', strtotime($latest_at));
    }
}
