<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/4
 * Time: 10:29
 */

namespace app\index\model;
use app\index\model\Base as BaseModel;

class Comment extends BaseModel
{
    public function standard(){
        return $this->belongsTo('Standard','standard_id','id');
    }
}