<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 11:48
 */

namespace app\index\validate;

use app\index\validate\Base as BaseValudate;
class IDNumber extends BaseValudate
{
    protected $rule=[
        'id'=>'require|number'
    ];
    protected $msg=[
      'id.require'=>'ID必须有',
        'id.number'=>'ID必须为数字'
    ];
}