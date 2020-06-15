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
        return 'login_id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->login_password;
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
            'admin_group_id',
            'admin_name',
            'login_id',
            'login_password',
            'is_active',
            'is_deleted',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'login_password',
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

    public function setLoginPasswordAttribute($value)
    {
        $this->attributes['login_password'] = bcrypt($value);
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
