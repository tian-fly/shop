<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/2
 * Time: 20:09
 */

namespace app\index\model;
use app\index\model\Base as BaseModel;

class Order extends BaseModel
{
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }

    public function products(){
        return $this->belongsToMany('Product','order_product','product_id','order_id');
    }


    public static function getOrdersByUserNoDeal($uid){
        return self::with('products')->where(['user_id'=>$uid,'status'=>0])->order('create_time desc')->select();
    }
    public static function getOrdersByUserDeal($uid){
        $arr=array('in','1,2,3');
        return self::with('products')->where(['user_id'=>$uid,'status'=>$arr])->order('create_time desc')->select();
    }

    public static function getOrderByUser($uid,$oid){
        return self::with('products,user')->where(['user_id'=>$uid,'id'=>$oid])->find();
    }
}