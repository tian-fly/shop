<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/3
 * Time: 12:06
 */

namespace app\index\model;
use app\index\model\Base as BaseModel;

class Feedback extends BaseModel
{
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
}