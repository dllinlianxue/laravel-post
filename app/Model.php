<?php

namespace App;

//为命名空间类起的别名
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $guarded = [];
}
