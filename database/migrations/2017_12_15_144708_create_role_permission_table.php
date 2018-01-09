<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        Schema::create('admin_roles',function (Blueprint $table) {
           $table->increments('id');
           $table->string('name',30)->default('');
           $table->string('description',100)->default('');
           $table->timestamps();
        });
        //权限表
        Schema::create('admin_permissions',function (Blueprint $table) {
           $table->increments('id');
           $table->string('name',30)->default('');
           $table->string('description',100)->default('');
           $table->timestamps();
        });
        //角色和用户的关联表 表名不是复数 不用创建Model
        Schema::create('admin_role_user',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('role_id')->default(0);
            $table->timestamps();
        });
        //权限和角色的关联表
        Schema::create('admin_permission_role',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->default(0);
            $table->integer('permission_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_role_user');
        Schema::dropIfExists('admin_permission_role');
    }
}
