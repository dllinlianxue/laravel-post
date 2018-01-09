<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//laravel欢迎页面:
Route::get('/','LoginController@welcome');

////使用get方式访问testController下的index方法
//Route::get('/test','TestController@index');
////接受from表单数据的路由
//Route::post('/test','TestController@save');


//用户模块路由:
//注册页面
Route::get("/register", "RegisterController@index");
//注册行为
Route::post("/register", "RegisterController@register");
//登陆页面
Route::get("/login", "LoginController@index");
//登陆行为
Route::post("/login", "LoginController@login");
//退出登录
Route::get("/logout", "LoginController@logout");
//个人中心页面
Route::get("/user/{user}", "UserController@show");
//关注行为
Route::post("/user/{user}/fan", "UserController@fan");
//取消关注行为
Route::post("/user/{user}/unfan", "UserController@unfan");
//通知界面
Route::get("/notices", "NoticeController@index");





//文章模块的路由:
//文章首页
Route::get("/posts", "PostController@index");
//文章添加界面
Route::get("/posts/create", "PostController@create");
//搜索行为
Route::get("/posts/search", "PostController@search");

//文章添加行为
Route::post("/posts","PostController@store");
//文章详情
Route::get("/posts/{post}", "PostController@show");

//文章编辑界面
Route::get("/posts/{post}/edit", "PostController@edit");
//文章编辑行为
Route::put("/posts/{post}","PostController@update");
//文章删除行为
Route::get("/posts/{post}/delete", "PostController@delete");

//图片上传接口
Route::post("/posts/image/upload", "PostController@imageUpload");

//评论行为
Route::post("/posts/{post}/comment", "PostController@comment");

//赞行为
Route::get("/posts/{post}/zan", "PostController@zan");
//取消赞
Route::get("/posts/{post}/unzan", "PostController@unzan");





//专题模块路由:
//专题详情界面
Route::get("/topic/{topic}", "TopicController@show");
//专题投稿行为
Route::post("/topic/{topic}/submit", "TopicController@submit");


//引入后台相关路由
//require_once('admin.php');

Route::group(['prefix'=>'admin'],function (){
    //prefix---->前缀
//    Route::get("/login", function (){
//        return '这是后台登录页面';
//    });
    //测试页面

    //登录界面
    Route::get("/login", "\App\Admin\Controllers\LoginController@index");
    //登录行为
    Route::post("/login", "\App\Admin\Controllers\LoginController@login");
    //退出登录行为
    Route::get("/logout", "\App\Admin\Controllers\LoginController@logout");


    //约束:middleware=中间设备  auth:admin=之前存的
    Route::group(['middleware'=>'auth:admin'],function (){
        //首页界面
        Route::get("/home", "\App\Admin\Controllers\HomeController@index");


        //文章审核部分:
        Route::group(['middleware'=>'can:post'],function (){
            //can:permission 权限里的名字 看是否能查看这个权限
            //文章管理列表界面
            Route::get("/posts", "\App\Admin\Controllers\PostController@index");
            //通过或拒绝文章管理
            Route::post("/posts/{post}/status", "\App\Admin\Controllers\PostController@status");

        });


        //专题部分:
        Route::group(['middleware'=>'can:topic'],function (){
//            //专题管理界面
//            Route::get("/topics", "\App\Admin\Controllers\TopicController@index");
//            //增加专题管理界面
//            Route::get("/topics/create", "\App\Admin\Controllers\TopicController@create");
//            //增加专题管理行为
//            Route::post("/topics", "\App\Admin\Controllers\TopicController@add");
//            //删除专题行为
//            Route::get("/topics/{topic}/delete", "\App\Admin\Controllers\TopicController@delete");
            Route::resource("topics","\App\Admin\Controllers\TopicController",['only'=>['index','create','store','destroy']]);
            //['only'=>[controller四个方法]]

        });

        //系统管理部分:(后台用户,角色,权限)
        Route::group(['middleware'=>'can:system'],function (){
            //用户管理首页
            Route::get("/users", "\App\Admin\Controllers\UserController@index");
            //用户增加页面
            Route::get("/users/create", "\App\Admin\Controllers\UserController@create");
            //用户增加行为
            Route::post("/users/store", "\App\Admin\Controllers\UserController@store");
            //该用户角色管理界面
            Route::get("/users/{user}/role", "\App\Admin\Controllers\UserController@role");
            //用户的角色修改的行为
            Route::post("/users/{user}/role", "\App\Admin\Controllers\UserController@storeRole");


            //角色管理首页
            Route::get("/roles", "\App\Admin\Controllers\RoleController@index");
            //角色增加页面
            Route::get("/roles/create", "\App\Admin\Controllers\RoleController@create");
            //角色增加行为
            Route::post("/roles/store", "\App\Admin\Controllers\RoleController@store");
            //该角色权限管理界面
            Route::get("/roles/{role}/permission", "\App\Admin\Controllers\RoleController@permission");
            //角色的权限修改的行为
            Route::post("/roles/{role}/permission", "\App\Admin\Controllers\RoleController@storePermission");


            //权限管理首页
            Route::get("/permissions", "\App\Admin\Controllers\PermissionController@index");
            //增加权限界面
            Route::get("permissions/create", "\App\Admin\Controllers\PermissionController@create");
            //增加权限行为
            Route::post("/permissions/store", "\App\Admin\Controllers\PermissionController@store");

        });

        //通知管理模块:
        Route::group(['middleware'=>'can:notice'],function (){
//           //通知管理首页
//             Route::get("/notices", "\App\Admin\Controllers\NoticeController@index");
//           //通知管理增加界面
            Route::resource("notices","\App\Admin\Controllers\NoticeController",['only'=>['index','create','store']]);
        });

    });

});


