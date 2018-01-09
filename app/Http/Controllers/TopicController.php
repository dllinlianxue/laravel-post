<?php

namespace App\Http\Controllers;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        //带文章数的专题:
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //获取专题的所有文章
        $posts = $topic->posts()->orderBy('created_at', 'desc')->get();
        //不属于这个专题的文章
        $other_posts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        return view('topic.show',compact('topic','posts','other_posts'));

    }
    //投稿行为
    public function submit(Topic $topic)
    {
        $this->validate(request(),[
           'post_ids'=>'required|array'
        ]);
        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id)
        {
         \App\PostTopic::firstOrCreate(compact('topic_id','post_id'));
        }
        return back(); //刷新当前页面
    }

}
