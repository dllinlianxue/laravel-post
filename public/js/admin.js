/**
 * Created by intern on 2017/12/15.
 */
$.ajaxSetup({
    headers : {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//为通过,拒绝按钮添加点击事件
$('.post-audit').click(function () {
   var post_id = $(this).attr('post-id');
   var status = $(this).attr('post-action-status');
   var url = '/admin/posts/'+ post_id +'/status';
   var target = $(event.target);
   $.post(url,{'status':status},function (result) {
       if (result.code == 1) {
           //状态修改完毕:移除此行<tr>
           target.parent().parent().remove();
       }
   },'JSON');
});


//为专题界面的删除按钮添加点击事件
$('.resource-delete').click(function (event) {
   if (confirm('确定删除?') === false) {
       //confirm()js原生写法
       return;
   }

   var url = $(this).attr('delete-url');
   $.post(url,{'_method':'DELETE'},function (result) {
       //请求方式:delete 大写
       if (result.code == 1) {
           //成功:
          window.location.reload();
       }
   },'JSON');
});
