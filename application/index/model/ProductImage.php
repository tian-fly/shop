<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 10:18
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;

class ProductImage extends BaseModel
{

    protected $hidden=['id','img_id','product_id','create_time','update_time','delete_time'];
    public function image(){
        return $this->belongsTo('Image','img_id','id');
    }
}