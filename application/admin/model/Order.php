<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/7
 * Time: 21:17
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;


class Order extends BaseModel
{
    protected $dateFormat='Y-m-d H:i:s';

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }

    public function products(){
        return $this->belongsToMany('Product','order_product','product_id','order_id');
    }


    public static function noGetMoney(){
        return self::with('products,user')->where(['status'=>0])->order('create_time desc')->paginate(7);
    }
    public static function getMoney(){
        return self::with('products,user')->where(['status'=>1])->order('create_time desc')->paginate(7);

    }
    public static function getProduct(){
        return self::with('products,user')->where(['status'=>2])->order('create_time desc')->paginate(7);

    }
    public static function successTrade(){
        return self::with('products,user')->where(['status'=>3])->order('create_time desc')->paginate(7);

    }


    public static function getOrderByUser($uid,$oid){
        return self::with('products,user')->where(['user_id'=>$uid,'id'=>$oid])->find();
    }

    public static function search($l,$r,$content){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'order_no'=>$content])->paginate(7);
    }

    public static function search1($l,$r){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr])->paginate(7);
    }

    public static function search2($content){
        return self::where(['order_no'=>$content])->paginate(7);
    }

}