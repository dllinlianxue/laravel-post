<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('register.index');
    }

    //注册行为
    public function register()
    {
        //验证数据
        $this->validate(request(),[
            'name'=> 'required|min:3|unique:users,name',
            'email'=>'required|unique:users,email|email',
//            unique:表名,字段
            'password'=>'required|min:5|confirmed'
//            约定password_confirmed是否一致
        ]);
        //存储
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
        //bcrypt()加密
        User::create(compact('name','email','password'));
        return redirect('/login');
        //Redirect::to()助手函数
    }
}
