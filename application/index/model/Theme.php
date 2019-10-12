<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 9:59
 */

namespace app\index\model;


use app\index\model\Base as BaseModel;


class Theme extends BaseModel
{
    protected $hidden=['products.pivot','products.centerImg_id','image_id','create_time','update_time','delete_time','image.id'];

    public static function getAll(){
//       return self::all([],['image']);
        return self::with(['image'])->select();
    }

    public static function getOne($id){
        return self::where(array('id'=>$id))->with(['image','products','products.centerImg'])->find();
    }
    //获取主题图片
   public function image(){
       return $this->belongsTo('Image','image_id','id');
   }

    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }
}