<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/3
 * Time: 13:08
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;
use traits\model\SoftDelete;

class Feedback extends BaseModel
{
    use SoftDelete;


    public static function getAll(){
        return self::with('user')->paginate(7);
    }

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
}