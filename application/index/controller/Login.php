<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 18:54
 */

namespace app\index\controller;
use app\index\model\User as UserModel;

use think\Controller;
use think\Request;
use think\captcha\Captcha;
use think\Session;

class Login extends Controller
{
    public function index(){

       return $this->fetch();
    }



    public function login(Request $request){
//        $code=$request->only('code','post'); 数组
        $code=input('post.code');
        if(!captcha_check($code)){
            return  [
                'status'=>0,
                'message'=>'验证码错误'
            ];
        }

        $data=$request->except('code,saveForm','post');
//        $data['password']=md5($data['password']);
        $user=UserModel::getUser($data);
        if(!$user){
            return [
              'status'=>0,
              'message'=>'用户名或密码错误'
            ];
        }elseif($user->getData('status')==0){
            return [
                'status'=>0,
                'message'=>'用户账号异常，请联系我服'
            ];
        } else{
//            cookie('userForm.name',$data['user_name'],24*60*60);
//            cookie('userForm.password',$data['password'],24*60*60);
            if(input('post.saveForm')==="yes"){

                cookie('userForm',$data['user_name'],24*60*60);
            }else{
                if(!empty(cookie('userForm'))){
                    cookie('userForm',null);
                }

            }
            Session::set('user_info',$user);
            return [
                'status'=>1,
                'message'=>'登入成功->>>>>'
            ];
        }

    }

    public function captcha(){
        $config =    [
            'fontSize'    =>    16,
            'length'      =>    4,
            'useNoise'    =>    false,
            'codeSet'=>'0123456789',
            'imageW'=>100,
            'imageH'=>50,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function logout()
    {

        Session::delete('user_info');
        return ['status'=>1,'message'=>'退出成功'];
    }



    public function register(){
        return $this->fetch();
    }

}