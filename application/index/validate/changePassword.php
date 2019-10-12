<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/2
 * Time: 10:50
 */

namespace app\index\validate;

use think\Validate;
class changePassword extends Validate
{
    protected $rule=[
        'password'=>'require',
        'newPassword'=>'require|alphaNum|length:6,10|different:password',
        'rePassword'=>'require|confirm:newPassword'
    ];
    protected $message=[
        'password.require'=>'请输入旧密码',
        'newPassword.require'=>'新密码必须哦',
        'newPassword.alphaNum'=>'新密码只能是数字和字母组成哦',
        'newPassword.length'=>'新密码的长度为6到10位哦',
        'newPassword.different'=>'新密码不能和旧密码一样',
        'rePassword.require'=>'确认密码必须',
        'rePassword.confirm'=>'确认密码与新密码不一致',
    ];

}