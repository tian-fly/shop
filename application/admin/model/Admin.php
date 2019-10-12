<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/6
 * Time: 19:28
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;
use traits\model\SoftDelete;

class Admin extends  BaseModel
{
    use SoftDelete;
    protected $auto=[
        'delete_time'=>NULL,
    ];
    protected $insert=[
        'is_delete'=>1
    ];
    protected $hidden=['password','update_time','delete_time'];
//    public static function getAllAdmin(){
//        return self::order('create_time asc')->paginate(8);
//    }
//
//    public static function getOneAdmin($id){
//        return self::get($id);
//    }
//
//    public static function deleteAdmin($id){
//        return self::destroy($id);
//    }

    public function getStatusAttr($value){
        $status=[
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }

    /*  public function setPasswordAttr($value){
          return md5($value);
      }*/



    public function role(){
        return $this->belongsTo('Role','role_id','id');
    }

}
