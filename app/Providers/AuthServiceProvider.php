<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//权限的服务提供者
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册Gate:
        $permissions = \App\AdminPermission::all();//获取所有的权限
        foreach ($permissions as $permission){
            //循环会出现四个权限:
            Gate::define($permission->name,function ($user) use ($permission){
                //function($user)可以确定你当前登录的用户名
                //function() use () {}作为匿名回调函数 使用参数 use(参数)
                return $user->hasPermission($permission);
            });
        }
    }
}
