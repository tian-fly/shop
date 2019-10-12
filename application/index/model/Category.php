<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 11:43
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;
class Category extends BaseModel
{
    public static function getAll(){
        return self::with(['products'=>function($query){
            $query->with(['centerImg'])
                ->where(['status'=>1]);
        }])
            ->select();
    }

    public static function getOne($id){
        return self::with(['products'=>function($query){
            $query->with(['centerImg'])
                ->where(['status'=>1]);
            }])
            ->where(array('id'=>$id))->find();

//        [
//            'imgs' => function ($query)
//            {
//                $query->with(['imgUrl'])
//                    ->order('order', 'asc');
//            }])
    }

    public function products(){
        return $this->hasMany('Product','category_id','id');
    }
}