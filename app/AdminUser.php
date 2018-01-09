<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authentication;

class AdminUser extends Authentication
{
    protected $remember_token = [];
    protected $guarded = [];

    //这个用户有哪些角色
    public function roles()
    {
        return $this->belongsToMany('App\AdminRole','admin_role_user','user_id','role_id')->withPivot(['user_id','role_id']);
    }

    //判断这个用户是否拥有某个角色  取一个数组
    public function isInRoles($roles)
    {
       return $this->roles->intersect($roles)->count();
       //查看$this->roles是否全不包含$roles角色 intersect()交叉
    }

    //给一个用户分配角色 根据key分配两组数组
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    //给一个用户取消某个角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
        //detach()分离
    }

    //用户是否有某个权限
    public function hasPermission($permission)
    {
      return $this->isInRoles($permission->roles);
    }
}
