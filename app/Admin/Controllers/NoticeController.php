<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;
use App\Notice;
class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index',compact('notices'));
    }

    public function create()
    {
        return view('admin.notice.create');
    }

    public function store()
    {
        //创建通知:
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required'
        ]);

        $notice = Notice::create(request(['title','content']));
        //分发通知:
        dispatch(new \App\Jobs\SendMessage($notice));
        return redirect('/admin/notices');
    }
}