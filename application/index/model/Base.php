<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 10:05
 */
namespace app\index\model;
use think\Model;
class Base extends Model
{
    protected $autoWriteTimestamp=true;
    protected $hidden=['create_time','update_time','delete_time'];
}