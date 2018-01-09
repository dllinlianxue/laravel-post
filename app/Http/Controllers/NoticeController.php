<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/18
 * Time: 下午3:51
 */
namespace App\Http\Controllers;

class NoticeController extends Controller {
    public function index()
    {
        $notices = \Auth::user()->notices;
        return view('notice.index',compact('notices'));
    }
}