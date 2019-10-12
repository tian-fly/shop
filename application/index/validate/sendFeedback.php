<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/3
 * Time: 12:22
 */

namespace app\index\validate;

use think\Validate;
class sendFeedback extends Validate
{
    protected  $rule=[
        'content'=>'length:1,160'
    ];
    protected $message=[
        'content.length'=>'内容不能超过160字'
    ];
}