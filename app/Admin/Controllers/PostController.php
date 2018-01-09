<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:22
 */
namespace App\Admin\Controllers;

use App\Post;

class PostController extends Controller
{
    public function index()
    {
        //获取所有文章
        $posts = \App\Post::where('status',0)->orderBy('created_at','desc')->paginate(5);
        return view('admin.post.index',compact('posts'));
    }

    //文章审核的触发事件
    public function status(Post $post)
    {
        $this->validate(request(),[
           'status'=>'required|in:-1,1'
        ]);

        $post -> status = request('status');
        $post -> save();

        return [
          'code' => 1
        ];
    }


}