<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //个人中心页面
    public function show(User $user)
    {
      //这个人的基本信息:文章数,关注的人数,粉丝数
      $user = User::withCount(['posts','fans','stars'])->find($user->id);
      //获取这个人的所有文章
//      $posts = $user->posts;
        $posts = $user->posts()->orderBy('created_at','desc')->paginate(3);
      //他的粉丝信息:文章数,粉丝数,其关注的人数
      $fans = $user->fans;
      $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['posts','fans','stars'])->get();
      //pluck()的方法:根据指定key把集合中的对应值全部取出,形成一个数组
      //他的关注的人信息:文章数,粉丝数,其关注的人数
      $stars = $user->stars;
      $susers = User::whereIn('id',$stars->pluck('start_id'))->withCount(['posts','fans','stars'])->get();
      //向前端发送数据
      return view('user.show',compact('user','posts','fusers','susers'));
    }

    //关注某个用户
    public function fan(User $user)
    {
        $current_user = \Auth::user();
        $current_user ->doFan($user->id);
        //获取user的所有粉丝及其相关信息
        $fans = $user->fans;
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['posts','fans','stars'])->get();
        foreach ($fusers as $fuser) {
            if ($current_user->hasFan($fuser->id)){
                $fuser->setAttribute('focus',true);
            }
            else {
                $fuser->serAttribute('focus',false);
            }
        }
        return [
            'code'=>1,
            'fusers'=>$fusers,
            'cur_user_id'=>\Auth::id()
        ];
    }
    //取消关注某个用户
    public function unfan(User $user)
    {
        $current_user = \Auth::user();
        $current_user ->doUnFan($user->id);
        return [
            'code'=> -1
        ];
    }
}
