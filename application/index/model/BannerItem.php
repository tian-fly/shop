<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 12:12
 */

namespace app\index\model;


use app\index\model\Base as BaseModel;

class BannerItem extends BaseModel
{


    public function images(){
        return $this->belongsTo('Image','img_id','id');
    }


}