<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;

use App\AdminRole;

class RoleController extends Controller
{
    //角色管理界面首页
    public function index()
    {
        $roles = AdminRole::all();
        return view('admin.role.index',compact('roles'));
    }

    //角色增加界面
    public function create()
    {
        return view('admin.role.create');
    }
    //角色增加行为
    public function store()
    {
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required|max:100'
        ]);

        AdminRole::create([
            'name'=>request('name'),
            'description'=>request('description')
        ]);

        return redirect('/admin/roles');
    }

    //权限列表界面
    public function permission(AdminRole $role)
    {
        //所有权限
        $permissions = \App\AdminPermission::all();
        //获取这个role拥有的权限
        $myPermissions = $role->permissions;
        return view('admin.role.permission',compact('role','permissions','myPermissions'));
    }

    //修改权限的行为
    public function storePermission(AdminRole $role)
    {
        $this->validate(request(),[
          'permissions'=>'required|array'
       ]);

        $permissions = $role->permissions;
        $newPermissions = \App\AdminPermission::findMany(request('permissions'));

        $addPermissions = $newPermissions->diff($permissions);
        foreach ($addPermissions as $permission)
        {
            $role->grantPermission($permission);
        }

        $deletePermissions = $permissions->diff($newPermissions);
        foreach ($deletePermissions as $permission)
        {
            $role->deletePermission($permission);
        }

        return back();

    }
}