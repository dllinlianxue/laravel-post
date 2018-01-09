<?php

namespace App;

use App\Model;

class Topic extends Model
{
    //属于这个专题的所有文章
    public function posts()
    {
        return $this->belongsToMany('App\Post','post_topics','topic_id','post_id');
    }
    //获取专题文章(数)
    public function postTopics()
    {
        return $this->hasmany('App\PostTopic','topic_id','id');
    }
}
