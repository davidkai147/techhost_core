<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Policies\Auth\AdminPolicy;
use App\Policies\Auth\RolePolicy;
use App\Policies\Auth\UserPolicy;
use App\Policies\Posts\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Post::class     => PostPolicy::class,
        User::class     => UserPolicy::class,
        Role::class     => RolePolicy::class,
        Admin::class    => AdminPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
