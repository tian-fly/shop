<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/3
 * Time: 12:07
 */

namespace app\index\controller;
use app\index\controller\Base as BaseController;
use app\index\model\Feedback as FeedbackModel;
use app\index\validate\sendFeedback as sendFeedbackValidate;

class Feedback extends BaseController
{
    public function index(){
        return $this->fetch();
    }

    public function send(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $data=input('post.');

        $validate=new sendFeedbackValidate();
        if(!$validate->check($data['content'])){
            return  [
                'status'=>0,
                'message'=>$validate->getError()
            ];
        };

        $uid=$this->getUid();
        $data['user_id']=$uid;
        $result=FeedbackModel::create($data);
        if($result){
            return [
                'status'=>1,
                'message'=>'发送成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'发送失败'
            ];
        }
    }


}