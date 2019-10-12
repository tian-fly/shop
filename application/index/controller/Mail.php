<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/15
 * Time: 10:25
 */

namespace app\home\controller;

use PHPMailer\PHPMailer\PHPMailer;
use think\Controller;
use app\home\model\User as UserModel;
use app\home\validate\User as UserValidate;
use think\Request;

class Mail extends Controller
{
  public function sendEmail(){

      $user_name=input('get.user_name');
      $user_email=input('get.email');
      $mail= new PHPMailer();
      $mail->isSMTP();
      $mail->CharSet="utf8";
      $mail->Host="smtp.qq.com";
      $mail->SMTPAuth=true;
      $mail->Username="2415597530@qq.com";
      $mail->Password="ptownclkvoczdjbj";
      $mail->SMTPSecure="ssl";
      $mail->Port=465;
      $mail->isHTML(true);

      $mail->setFrom("2415597530@qq.com","tian");
      $mail->addAddress($user_email,$user_name);
      $mail->addReplyTo("2415597530@qq.com","Replay");
//      $mail->addCC("");
//      $mail->addBCC("");
//      $mail->addAttachment("")//附件
      $mail->Subject="找回密码";
      $mail->Body="请在一分钟之内输入,验证码：".$this->createFourNumber($user_name);
      $mail->send();
//      if(!$mail->send()){
//          echo "发送错误";
//          echo $mail->ErrorInfo;
//      }else{
//          echo "发送成功";
//      }
  }

    public function cBackPassword(){
        return $this->fetch();
    }

    public function checkedBackPasswordData(){
        $data=input('post.');
        $user=UserModel::get(['user_name'=>$data['user_name'],'email'=>$data['email']]);
        if(!$user){
            return ['status'=>0,'message'=>'用户名与注册时使用邮箱不匹配'];
        }else{

            return ['status'=>1,'user_name'=>$user['user_name'],'email'=>$user['email']];
        }
    }

    public function getCode(){

        $this->sendEmail();
        return $this->fetch();
    }

    public function checkedCode(){
        $user_name=input('post.user_name');
        $email=input('post.email');
        $code=input('post.code');
        if($code!==cache($user_name)){
            return ['status'=>0,'message'=>'验证超时或输入验证数字错误'];
        }else{
            return ['status'=>1,'user_name'=>$user_name,'email'=>$email];
        }
    }


    public function newPassword(){
//        $user_name=input('get.user_name');
//        $email=input('get.email');
        return $this->fetch();
    }

    public function checkedNewPassword(){

        $data=Request::instance()->only(['password','rePassword'],'post');
        $result=$this->validate($data,'User.newPassword');
//        $validate	=	Loader::validate('User.register');
//        $result=$validate->batch()->check($data);

        if(true!==$result){
            return  [
                'status'=>0,
                'message'=>$result
//                'message'=>$validate->getError()
            ];
        }

        $datas=Request::instance()->only(['user_name','email'],'post');
        $result=UserModel::where(['user_name'=>$datas['user_name'],'email'=>$datas['email']])->update(['password'=>input('post.password')]);
        if($result){
            return [
                'status'=>1,
                'message'=>'重置密码成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'重置密码失败'
            ];
        }

    }



    private function createFourNumber($user_name){
        $str='';
        $num_str='0123456789';
        for($i=0;$i<4;$i++){
            $str.=$num_str[rand(0,9)];
        }
        cache($user_name,$str,60);
        return $str;

    }

}