/**
 * Created by intern on 2017/12/8.
 */

$.ajaxSetup({
    headers : {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//点赞操作
$('#zanImg').click(function () {
    //向后台发送点赞或取消赞
   var status = $(this).attr('name');
   var post_id = $(this).attr('alt');
   var url = '';
   if (status === 'unzan') {
       //准备去赞
       url = '/posts/'+ post_id +'/zan';
   }
   if (status === 'zan') {
       //准备取消赞
       url = '/posts/'+ post_id +'/unzan'
   }

   //发起请求
   $.get(url,null,function (result) {
       if (result.code == 1) {
           // console.log(result);
           //点赞成功 : 换图
           $('#zanImg').attr('src','/image/zan.png');
           $('#zanImg').attr('name','zan');
       }
       if (result.code == -1) {
           //取消赞成功  : 换图
           $('#zanImg').attr('src','/image/unzan.png');
           $('#zanImg').attr('name','unzan');
       }
   },'JSON');
});

//关注 和 取消关注 的事件
$('body').on('click','.like-button',function (event) {
   var status = $(this).attr('like-value');
   var des_user_id = $(this).attr('like-user');
   var url = '/user/' + des_user_id + '/';
   var target = $(event.target);
   var type = $(this).attr('like-type');
   if (status == 1) {
       //取消关注
       url += 'unfan';
       $.post(url,null,function (result) {
           if (result.code == -1) {
               console.log('取消关注成功');
               target.attr('like-value',0);
               target.text('关注');
               // window.location.reload();
           }
       },'JSON');
   }
   else {
       //去关注
       url += 'fan';
       $.post(url,null,function (result) {
           if (result.code == 1) {
               console.log('关注成功');
               target.attr('like-value',1);
               target.text('取消关注');
               // window.location.reload();
               if (type == 'top') {
                   //循环后端返回的结果fusers
                   var htmlString = "";
                   $(result.fusers).each(function () {
                      htmlString += '<div class="blog-post" style="margin-top: 30px">' +
                                    '<p class="">'+this.name+'</p>' +
                                    '<p class="">关注：'+this.stars_count+' | 粉丝：'+this.fans_count+'｜ 文章：'+this.posts_count+'</p>';
                      //判断添加什么样的按钮:
                       if (this.id != result.cur_user_id){
                           //添加关注按钮
                           htmlString += '<button class="btn btn-default like-button" like-value="0" like-user="'+this.id+'" type="button" like-type="bottom">关注</button>';
                       }
                       else  {
                           //添加取消按钮
                           htmlString += '<button class="btn btn-default like-button" like-value="1" like-user="'+this.id+'" type="button" like-type="bottom">取消关注</button>';
                       }
                   });
                          htmlString + '</div>';
                   $('#tab_3').html(htmlString);
               }
           }
       },'JSON');
   }
});