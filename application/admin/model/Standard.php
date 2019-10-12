<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/5
 * Time: 15:58
 */

namespace app\admin\model;

use app\admin\model\Base as BaseModel;
class Standard extends BaseModel
{

    protected $dateFormat="Y-m-d H:i:s";
    public function getStatusAttr($value){
        $status=[
            0=>'下架',
            1=>'在架'
        ];
        return $status[$value];
    }

//    public function image(){
//        return $this->belongsTo('Image','centerImg_id','id');
//    }
    public function centerImg(){
        return $this->belongsTo('Image','centerImg_id','id');
    }
    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
}