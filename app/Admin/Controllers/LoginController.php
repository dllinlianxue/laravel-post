<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;

class LoginController extends Controller
{
    //登录界面
    public function index()
    {
        return view ('admin.login.index');
    }

    //登录行为
    public function login()
    {
        $this->validate(request(),[
            'name'=>'required|min:3',
            'password'=>'required'
        ]);
        $adminData = request(['name','password']);
        if (\Auth::guard('admin')->attempt($adminData))
        {
            return redirect('/admin/home');
        }
        return back()->withErrors('登录失败');
    }

    //退出登录界面
    public function logout()
    {
      \Auth::guard('admin')->logout();
      return redirect('/admin/login');
    }
}