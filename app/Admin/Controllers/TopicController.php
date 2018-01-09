<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;
use App\Topic;
class TopicController extends Controller
{
    //专题界面
    public function index()
    {
        //获取所有专题
        $topics = \App\Topic::orderBy('created_at','desc')->get();
        return view('admin.topic.index',compact('topics'));
    }

    //增加专题界面
    public function create()
    {
        return view('admin.topic.create');
    }

    //增加专题行为
    public function store()
    {
        $this->validate(request(),[
           'name'=>'required'
        ]);
        \App\Topic::create(['name'=>request('name')]);

        return redirect('/admin/topics');
    }

    //删除专题行为
    public function destroy(Topic $topic)
    {
        //TODO:删除post_topic中的此专题所有记录
        //删除这个专题:
        $topic->delete();
        return [
          'code' => 1
        ];

    }


}