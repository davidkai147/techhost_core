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
        return $this->query->whereRaw("AES_DECRYPT(nickname, '".config('applican.encrypt_keyword')."') like '%".$nickname."%'");
    }

    /**
     * Filter user by login_id
     *
     * @param $login_id
     * @return \App\Builders\Builder
     */
    public function login_id($login_id)
    {
        return $this->query->whereRaw("AES_DECRYPT(login_id, '".config('applican.encrypt_keyword')."') like '%".$login_id."%'");
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
