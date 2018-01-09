<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authentication;

class User extends Authentication
{
   protected $guarded = [];

    //获取一个用户有多少文章
    //$user->posts;获取所有文章;   $user->posts()->save();在文章加一条数据;
    //在User表,一对多-->hasmany(),
    public function posts()
    {
       return $this->hasmany('App\Post','user_id','id');
    }
    //获取这个用户的所有粉丝
    public function fans()
    {
        return $this->hasmany('App\Fan','star_id','id');
    }
    //获取这个用户的关注所有人
    public function stars()
    {
        return $this->hasmany('App\Fan','fan_id','id');
        //'id'-->user表里的id;'fan_id'--->fan表里的'
    }
    //关注某人
    public function doFan($user_id)
    {
        $fan = new \App\Fan();
        $fan->star_id = $user_id;
        //user表里的id,关注他人,是fan表里的粉丝star_id
        return $this->stars()->save($fan);
    }
    //取消关注某人
    public function doUnFan($user_id)
    {
        $fan = new \App\Fan();
        $fan->star_id = $user_id;
        return $this->stars()->delete($fan);
    }
    //此用户是否关注了$user_id对应的用户
    public function hasFan($user_id)
    {
        return $this->stars()->where('star_id',$user_id)->count();
    }
    //此用户是否被$user_id对应的用户关注
    public function hasStar($user_id)
    {
        return $this->fans()->where('fan_id',$user_id)->count();

    }

    //获取这个用户有哪些通知
    public function notices()
    {
        return $this->belongsToMany('\App\Notice','user_notice','user_id','notice_id');
    }

    //给这个用户发送通知:
    public function addNotice(Notice $notice)
    {
        return $this->notices()->save($notice);
    }

}
