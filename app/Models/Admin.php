<?php

namespace App\Models;

use App\Builders\Auth\AdminBuilder;
use App\Interfaces\AuthInterface;
use App\Traits\HasModify;
use App\Traits\HasUuid;
use App\Traits\OverridesBuilder;
use App\Traits\ParseDateToTimestamp;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject, AuthInterface
{
    use ParseDateToTimestamp;
    use Notifiable;
    use HasUuid;
    use HasRoles;
    use OverridesBuilder;
    use HasModify;
    public function isAdmin(): bool
    {
        return true;
    }

    public function isSystemAdmin(): bool
    {
        if ($this->adminGroup->is_system){
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return 'email';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function provideCustomBuilder()
    {
        return AdminBuilder::class;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'birthday',
        'gender',
        'post_code',
        'city_name',
        'address',
        'tel',
        'is_active',
        'is_deleted',
        'email_verified_at',
        'remember_token',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    public $timestamps = false;

    // ======================================================================
    // Accessors & Mutators
    // ======================================================================

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get company of this admin
     *
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function getCompanyAttribute(){
        return $this->adminGroup->company;
    }
    // ======================================================================
    // Relationships
    // ======================================================================

    /**
     * Admin belongsTo AdminGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminGroup(){
        return $this->belongsTo(AdminGroups::class);
    }


}
