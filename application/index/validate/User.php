<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 20:22
 */

namespace app\index\validate;


use think\Validate;

class User extends Validate
{
    protected $rule=[
    'user_name'=>'require|chsAlphaNum|length:4,8',
    'password'=>'require|alphaNum|length:6,10',
    'rePassword'=>'require|confirm:password',
    'phone'=>'require|isPhone',
        'qq'=>'number|length:5,10',
        'email'=>'require|email',
        'birthday'=>'dateFormat:Y-m-d',
        'motto'=>'length:10,50'
    ];
    protected $message=[
        'user_name.require'=>'用户名必须哦',
        'user_name.chsAlphaNum'=>'用户名必须只含有汉字、字母和数字哦',
        'user_name.length'=>'用户名的长度为4到8位哦',
        'password.require'=>'密码必须哦',
        'password.alphaNum'=>'密码只能是数字和字母组成哦',
        'password.length'=>'密码的长度为6到10位哦',
        'rePassword.require'=>'确认密码必须',
        'rePassword.confirm'=>'密码与确认密码不一致',
        'phone.require'=>'电话必须哦',
        'phone.isPhone'=>'电话格式错误哦',
        'qq'=>'qq只能为5到10位的数字组成哦',
        'email.require'=>'邮箱必须哦',
        'email.email'=>'邮箱格式错误哦',
        'birthday'=>'出生日期格式错误哦',
        'motto'=>'座右铭的长度为10到50位哦'
    ];
    protected $scene=[
        'editBase'=>['user_name','phone','qq','email','birthday','motto'],
        'register'=>['user_name','password','rePassword','phone','qq','email','birthday','motto'],
        'newPassword'=>['password','rePassword'],
    ];
    protected function isPhone($value,$rule,$data,$field){
           $match='/^1(3|5|7)\d{9}$/';
           $result=preg_match($match,$value);
           if($result){
               return true;
           }else{
               return false;
           }
    }

}