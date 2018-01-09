<?php

namespace App;


class AdminPermission extends Model
{
    //这个权限属于哪些角色
    public function roles()
    {
        return $this->belongsToMany('App\AdminRole','admin_permission_role','permission_id','role_id')->withPivot(['permission_id','role_id']);
    }
}
