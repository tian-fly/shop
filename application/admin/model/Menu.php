<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/11
 * Time: 22:01
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;
use traits\model\SoftDelete;


class Menu extends BaseModel
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

    public function getIsHiddenAttr($value){
        $isHidden=[
            0=>'不隐藏',
            1=>'隐藏'
        ];
        return $isHidden[$value];
    }
}