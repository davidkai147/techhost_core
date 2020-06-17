<?php

namespace App\Models;

use App\Builders\Auth\UserBuilder;
use App\Interfaces\AuthInterface;
use App\Traits\HasModify;
use App\Traits\HasUuid;
use App\Traits\OverridesBuilder;
use App\Traits\ParseDateToTimestamp;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\EncryptUser;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, AuthInterface
{
    use ParseDateToTimestamp;
    use Notifiable;
    use HasUuid;
    use HasRoles;
    use OverridesBuilder;
    use HasModify;
    use EncryptUser;

    public function isAdmin(): bool
    {
        return false;
    }

    public function provideCustomBuilder()
    {
        return UserBuilder::class;
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
        'user_number',
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
     * Check if the value already exists in the database
     *
     * @param  string $mail User number
     * @param  string $uid  Primary key
     *
     * @return bool
     */
    public static function doesUserNumberExist($number, $uid = '')
    {
        $query = self::whereRaw(
            'AES_DECRYPT(user_number, ?) = ?',
            [config('techhost.encrypt_keyword'), $number]
        );

        // For editing
        if ($uid) {
            $query->where('id', '!=', $uid);
        }

        return $query->exists();
    }

    /**
     * Generaete random numbers
     *
     * @param  integer $length Number of digits
     *
     * @return string
     */
    public static function generateRandomNumCode($length = 10)
    {
        while (true) {
            $max  = pow(10, $length) - 1;
            $rand = random_int(0, $max);
            $code = sprintf('%0'. $length. 'd', $rand);
            $res = User::doesUserNumberExist($code);
            if (!$res) {
                break;
            }
        }

        return $code;
    }

    // ======================================================================
    // Relationships
    // ======================================================================

    /**
     * User belongsTo Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo(Company::class);
    }

    /**
     * User belongsTo Prefecture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prefecture(){
        return $this->belongsTo(Prefecture::class);
    }
}
