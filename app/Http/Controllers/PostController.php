<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Zan;

class PostController extends Controller
{
    //首页
    public function index()
    {
        //查询所有文章  relations关联
        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(4);
        //排序-->获取结果集
        //all()方法所有条件
//      dd($posts); //dump and die 打印并终止
        return view('Post.index',compact('posts'));
        //返回界面,compact()
    }
    //详情
    public function show(Post $post)
        //Post这个类 里的参数
    {
        $zanName = $post->zan(\Auth::id())->exists() ?'zan' : 'unzan';
        return view('Post.show',compact('post','zanName'));
    }
    //添加界面
    public function create()
    {
        return view('Post/create');
    }
    //添加行为
    public function store()
    {
        //数据校验
        $this->validate(request(),[
            'title'=>'required|min:3',
            'content'=>'required'
        ]);
        //构造实例,添加到数据库
        $user_id = \Auth::id();
        $params = array_merge(request(['title','content']),compact('user_id'));
        Post::create($params);
        return redirect('/posts');
    }
    //编辑界面
    public function edit(Post $post)
    {
        return view('Post.edit',compact('post'));
    }
    //编辑行为
    public function update(Post $post)
    {
//        dd(request()->all());
        //接收数据,校验->存入数据库->渲染界面
        //校验 : 如果校验失败,会向来自的界面发送一个$errors的变量
        $this->validate(request(),[
            'title'=>'required|min:3|max:20',
            'content'=>'required'
        ]);
        //保存到数据库
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染界面,返回首页
        return redirect('/posts');
    }
    //删除行为
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/posts');
    }
    //图片上传
    public function imageUpload()
    {
//       dd(request()->all());
        $path = request()->file('wangEditorH5File')->storePublicly(time());
        //storePublicly()给图片文件夹命名  file发送
        return asset('storage/'.$path);
        //存储的路径
    }
    //评论行为
    public function comment(Post $post)
    {
        //数据校验
        $this->validate(request(),[
           'content'=>'required|min:5|max:100'
        ]);
        //保存数据
        $comment = new Comment();
        $comment ->post_id = $post->id;
        $comment ->user_id = \Auth::id();
        $comment ->content = request('content');
        $post->comments()->save($comment);

        //渲染
        return back();
    }

    //点赞行为
    public function zan(Post $post)
    {
        $params = [
            'post_id'=>$post->id,
            'user_id'=>\Auth::id()
        ];
        //有就直接使用,没有就创建
        Zan::firstOrCreate($params);
//        return back();
        return json_encode([
           'code' => 1
        ]);
    }

    //取消赞行为

    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
//        return back();
        return json_encode([
           'code' => -1
        ]);
    }

    //搜索方法
    public function search()
    {
        //校验
        $this->validate(request(),[
           'query'=>'required'
        ]);
        $query = request('query');
        //逻辑  根据query内容使用scout去elasticsearch服务中查询数据
        $posts = Post::search($query)->paginate(5);

        //渲染

        return view('post.search',compact('posts','query'));
    }
}
