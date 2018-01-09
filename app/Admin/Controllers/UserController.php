<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;

class UserController extends Controller
{
    //用户首页
    public function index()
    {
        //查询所有用户
        $users = AdminUser::orderBy('created_at','desc')->get();
        return view('admin.user.index',compact('users'));
    }

    //用户添加界面
    public function create()
    {
        return view('admin.user.create');
    }

    //用户添加行为
    public function store()
    {
        $this->validate(request(),[
           'name'=>'required|min:3',
            'password'=>'required|min:5'
        ]);
        AdminUser::create([
            'name'=>request('name'),
            'password'=>bcrypt(request('password'))
        ]);
         return redirect('/admin/users');
    }

    //该用户角色操作界面
    public function role(AdminUser $user)
    {
        //获取所有的角色信息
        $roles = \App\AdminRole::all();
        //获取我拥有的角色
        $myRoles = $user->roles;
        return view('admin.user.role',compact('user','roles','myRoles'));
    }

    //修改角色的行为
    public function storeRole(AdminUser $user)
    {
      $this->validate(request(),[
         'roles'=>'required|array'
      ]);
      //获取这个用户的所有角色
        $myRoles = $user->roles;
        $newRoles = AdminRole::findMany(request('roles'));//要修改的
        //需要添加的
        $addRoles = $newRoles->diff($myRoles);
        //$newRoles=123,$myRoles=234,结果=1(取出前面有的,后面没有的===>前面我独有的)
        foreach ($addRoles as $role)
        {
            $user->assignRole($role);
        }
        //需要删除的
        $deleteRoles = $myRoles->diff($newRoles);
        foreach ($deleteRoles as $role)
        {
            $user->deleteRole($role);
        }

        return back();
    }
}