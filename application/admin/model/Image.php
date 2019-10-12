<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 12:16
 */

namespace app\admin\model;

use app\admin\model\Base as BaseModel;
class Image extends BaseModel
{
    protected $hidden=['create_time','update_time','delete_time'];
  public function getImgUrlAttr($value){
      return 'http://www.shop.com'.$value;
  }

    public function category(){
        return $this->belongsTo('Category','category_id','id');
    }
}