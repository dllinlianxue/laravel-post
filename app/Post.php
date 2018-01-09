<?php

namespace App;

use App\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use Searchable;

    public function searchableArray()
    {
        return [
            'title'=>$this->title,
            'content'=>$this->content
        ];
    }

    public function searchableAs()
    {
        return 'post';
    }
    //规定哪些字段可以入库
//    protected $fillable = ['title','content'];
     //规定哪些字段不可以入库
//    protected $guarded = [];
    //所有字段都行

    //声明关联,一个方法一个关联,和用户表的关联,一篇文章有一个作者(用户)
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    //获取这个文章的多个评论
    public function comments()
    {
        return $this->hasmany('App\Comment');
    }

    //获取这个文章所有赞
    public function zans()
    {
        return $this->hasmany('App\Zan');
    }

    //判断某个用户是否对这篇文章点了赞
    public function zan($user_id)
    {
        return $this->hasone('App\Zan')->where('user_id',$user_id);
    }

    //属于某个作者的文章
    public function scopeAuthorBy(Builder $query, $user_id)
        //scopeAuthorBy()声明方法
    {
        return $query->where('user_id',$user_id);
    }

    //获取文章对应的所有post_topic记录
    public function postTopics()
    {
        return $this->hasMany('App\PostTopic','post_id','id');
    }

    //获取不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics','and',function ($q) use ($topic_id)
        {
         $q -> where('topic_id',$topic_id);
        });
    }


}

