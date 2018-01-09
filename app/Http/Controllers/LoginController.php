<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    //登录界面
    public function index()
    {
        return view('login.index');
    }

    //登录行为
    public function login()
    {
        //校验数据
        $this->validate(request(),[
            'email'=>'required|email',
            'password'=>'required',
            'is_remember'=>'integer'
        ]);
        $email = request('email');
        $password = request('password');
        $is_remember = boolval(request('is_remember'));
        if (\Auth::attempt(compact('email','password'),$is_remember)){
            return redirect('/posts');
        }
        return back();//回到请求之前的页面
    }

    //退出登录行为
    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}
