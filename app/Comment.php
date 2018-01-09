<?php

namespace App;

use App\Model;

class Comment extends Model
{
    //获取这个评论属于哪个文章
    public function post()
    {
        return $this->belongsTo('\App\Post','post_id','id');
        //'id'--->是post表里的id;'post_id'-->是comment表里的'post_id'
    }
    //获取这个评论属于哪个作者
    public function user()
    {
        return $this->belongsTo('\App\User','user_id','id');
    }
}
