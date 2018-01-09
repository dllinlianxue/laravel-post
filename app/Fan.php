<?php

namespace App;

use App\Model;

class Fan extends Model
{
  //获取这条Fan记录中粉丝的信息
    public function fuser()
    {
        return $this->hasone('App\User','id','fan_id');
        //'id'-->是user表里的id,和'fan_id'--->是fan表里的关注的人
    }
  //获取这条Fan记录中被关注着的信息
    public function suser()
    {
        return $this->hasone('App\Fan','id','star_id');
    }
}
