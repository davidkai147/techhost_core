<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace App\Filters;

use App\Traits\CommonFilter;
use App\Traits\EncryptUser;
use Illuminate\Support\Facades\DB;

class UserFilter extends Filter
{
    use CommonFilter;
    use EncryptUser;
    /**
     * Filter user by nickname
     *
     * @param  string  $name
     * @return \App\Builders\Builder
     */
    public function nickname($nickname)
    {
        return $this->query->whereRaw("AES_DECRYPT(nickname, '".config('techhost.encrypt_keyword')."') like '%".$nickname."%'");
    }

    /**
     * Filter user by email
     *
     * @param $email
     * @return \App\Builders\Builder
     */
    public function email($email)
    {
        return $this->query->whereRaw("AES_DECRYPT(email, '".config('techhost.encrypt_keyword')."') like '%".$email."%'");
    }

    /**
     *
     * Filter user by prefecture_id
     * @param $prefecture_id
     * @return \App\Builders\Builder
     */
    public function prefecture_id($prefecture_id)
    {
        return $this->query->where('prefecture_id', $prefecture_id);
    }

    /**
     * Filter user by is_active
     *
     * @param $is_active
     */
    public function is_active($is_active){
        return $this->query->where('is_active', $is_active);
    }
}
