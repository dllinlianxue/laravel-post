<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }
}