<?php

namespace App\Traits;

use App\Builders\Auth\UserBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait EncryptUser
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('decrypt', function (UserBuilder $builder) {
            $builder->select('*')
                    ->selectRaw('AES_DECRYPT(name, ?) AS name', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(email, ?) AS email', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(user_number, ?) AS user_number', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(birthday, ?) AS birthday', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(gender, ?) AS gender', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(post_code, ?) AS post_code', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(city_name, ?) AS city_name', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(address, ?) AS address', [config('techhost.encrypt_keyword')])
                    ->selectRaw('AES_DECRYPT(tel, ?) AS tel', [config('techhost.encrypt_keyword')]);
        });
    }

    /*
     *
     * @param  string $value User name
     *
     * @return void
     */
    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = $this->encrypt($value);
    }

    /*
     *
     * @param  string $value User number
     *
     * @return void
     */
    protected function setUserNumberAttribute($value)
    {
        $this->attributes['user_number'] = $this->encrypt($value);
    }

    /**
     * Set the User's birthday.
     *
     * @param string $value Birthday
     *
     * @return void
     */
    protected function setBirthdayAttribute($value)
    {
        $value = Carbon::parse($value)->timestamp;
        $this->attributes['birthday'] = $this->encrypt($value);
    }

    /**
     * Set the User's gender.
     *
     * @param string $value Gender
     *
     * @return void
     */
    protected function setGenderAttribute($value)
    {
        $this->attributes['gender'] = $this->encrypt($value);
    }

    /**
     * Set the User's post code.
     *
     * @param string $value Post code
     *
     * @return void
     */
    protected function setPostCodeAttribute($value)
    {
        $this->attributes['post_code'] = $this->encrypt($value);
    }

    /**
     * Set the User's city name.
     *
     * @param string $value City name
     *
     * @return void
     */
    protected function setCityNameAttribute($value)
    {
        $this->attributes['city_name'] = $this->encrypt($value);
    }

    /**
     * Set the User's address.
     *
     * @param string $value Address
     *
     * @return void
     */
    protected function setAddressAttribute($value)
    {
        $this->attributes['address'] = $this->encrypt($value);
    }

    /**
     * Set the User's tel.
     *
     * @param string $value Tel
     *
     * @return void
     */
    protected function setTelAttribute($value)
    {
        $this->attributes['tel'] = $this->encrypt($value);
    }

    /**
     * Encrypt fields related to personal informations.
     *
     * @param string $value Value to be encrypted
     *
     * @return \Illuminate\Database\Query\Expression
     */
    private function encrypt($value)
    {
        return DB::raw('AES_ENCRYPT("'.$value.'", "'.config('techhost.encrypt_keyword').'")');
    }
}
