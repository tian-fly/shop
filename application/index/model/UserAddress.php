<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 11:04
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;

class UserAddress extends BaseModel
{
    public static function findOne($id,$uid){
        return self::where(['id'=>$id,'user_id'=>$uid])->find();
    }

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
}