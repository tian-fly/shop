<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/5
 * Time: 15:58
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;
class Standard extends BaseModel
{
//    public function image(){
//        return $this->belongsTo('Image','centerImg_id','id');
//    }
    public function centerImg(){
        return $this->belongsTo('Image','centerImg_id','id');
    }
//    public function product(){
//        return $this->belongsTo('Product','product_id','id');
//    }
}