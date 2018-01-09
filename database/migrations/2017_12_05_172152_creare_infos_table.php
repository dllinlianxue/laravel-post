<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreareInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos',function (Blueprint $table) {
           $table->increments('id');
           $table->string('name',50)->default('');
           $table->string('address',100)->default('');
           $table->string('phoneNumber',20)->default('');
           $table->string('company',100)->default('');
           $table->string('email',50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infos');
    }
}
