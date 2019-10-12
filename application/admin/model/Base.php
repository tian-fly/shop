<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/7
 * Time: 15:20
 */

namespace app\admin\model;
use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp=true;
    protected $dateFormat='Y-m-d';
    protected $hidden=['update_time','delete_time'];
}