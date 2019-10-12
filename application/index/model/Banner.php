<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 10:04
 */
namespace app\index\model;
use app\index\model\Base as BaseModel;
class Banner extends BaseModel
{

    public static function getBanner($id){
        return self::with(['bannerItem','bannerItem.images'])->where(array('id'=>$id))->find();
    }

    public function bannerItem(){
        return $this->hasMany('BannerItem','banner_id','id');
    }


}