<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 12:16
 */

namespace app\index\model;

use app\index\model\Base as BaseModel;
class Image extends BaseModel
{
    protected $hidden=['id','create_time','update_time','delete_time'];
  public function getImgUrlAttr($value){
      return 'http://www.shop.com'.$value;
  }

}