<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/27
 * Time: 18:23
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;
use traits\model\SoftDelete;
class User extends BaseModel
{
    use SoftDelete;
    protected $auto=[
        'delete_time'=>NULL,

    ];
    protected $insert=[
        'is_delete'=>1
    ];

    public function getStatusAttr($value){
        $status=[
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }

    public static function allUsers(){
        return self::paginate(7);
    }

    public static function search($l,$r,$content){
        $contentArr=array('like','%'.$content.'%');
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'user_name'=>$contentArr])->paginate(7);
    }

    public static function search1($l,$r){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr])->paginate(7);
    }

    public static function search2($content){
        $contentArr=array('like','%'.$content.'%');
        return self::where(['user_name'=>$contentArr])->paginate(7);
    }

    public function passages(){
        return $this->hasMany('Passage','user_id','id');
    }
}