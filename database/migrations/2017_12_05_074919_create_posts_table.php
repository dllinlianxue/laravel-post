<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run运行 the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建posts表 -->post
        Schema::create('posts',function (Blueprint $table){
            //设置table的字段级类型
            $table->increments('id');
            $table->string('title',100)->default('');
            $table->text('content');
            $table->integer('user_id')->default(0);
            $table->timestamps();//同时添加 create_at和update_at 两个字段
        });
    }

    /**
     * Reverse移除 the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
