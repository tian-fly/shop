<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/29
 * Time: 11:13
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;

class User extends BaseModel
{

    public function getAvatarUrlAttr($value){
        return "http://www.shop.com".$value;
    }

    public static function getUser($data){
        return self::where($data)->find();
    }

    public function address(){
        return $this->hasMany('UserAddress','user_id','id');
    }

    public function comments(){
        return $this->hasMany('Comment','user_id','id');
    }
}