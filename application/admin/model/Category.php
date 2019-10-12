<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/9
 * Time: 22:57
 */

namespace app\admin\model;

use app\admin\model\Base as BaseModel;

class Category extends BaseModel
{
    public static function getAll(){
        return self::with('products,products.centerImg')->paginate(7);
    }

    public static function getOne($id){
        return self::with(['products','products.centerImg'])->where(array('id'=>$id))->find();
    }

    public function products(){
        return $this->hasMany('Product','category_id','id');
    }
}