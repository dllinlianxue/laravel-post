<?php

namespace App;


class AdminRole extends Model
{
    //当前角色有哪些权限
    public function permissions()
    {
        return $this->belongsToMany('App\AdminPermission','admin_permission_role','role_id','permission_id')->withPivot(['role_id','permission_id']);
    }

    //给某个角色赋予某个权限
    public function grantPermission($permission)
    {
        return $this->permissions()->save($permission);
    }

    //取消某个角色的权限
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    //判断一个角色是否拥有某个权限
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
        //contains()包含
    }

}
