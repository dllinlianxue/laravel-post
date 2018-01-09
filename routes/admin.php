<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/12/14
 * Time: 上午10:30
 */
//后台相关路由:
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