<?php
namespace App\Filters;

use App\Traits\CommonFilter;

class AdminFilter extends Filter
{
    use CommonFilter;


    /**
     * Filter admin by admin_name
     *
     * @param $admin_name
     * @return \App\Builders\Builder
     */
    public function admin_name($admin_name)
    {
        return $this->query->whereLike('admin_name', $admin_name);
    }


    /**
     * Filter admin by login_id
     *
     * @param $login_id
     * @return \App\Builders\Builder
     */
    public function login_id($login_id)
    {
        return $this->query->whereLike('login_id', $login_id);
    }

    /**
     * Filter admin by admin_group_id
     *
     * @param $login_id
     * @return \App\Builders\Builder
     */
    public function admin_group_id($admin_group_id)
    {
        return $this->query->where('admin_group_id', $admin_group_id);
    }

    /**
     * Filter admin by is_active
     *
     * @param $is_active
     */
    public function is_active($is_active){
        return $this->query->where('is_active', $is_active);
    }
}
