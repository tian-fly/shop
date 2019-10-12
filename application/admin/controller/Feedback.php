<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/3
 * Time: 13:08
 */

namespace app\admin\controller;
use app\admin\controller\Base as BaseController;
use app\admin\model\Feedback as FeedbackModel;
use think\Request;
class Feedback extends  BaseController
{
    public function feedback_list(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        $count=FeedbackModel::count();
        $feedback_list=FeedbackModel::getAll();
        $feedback_list=$feedback_list->hidden(['user.password']);


        $this->assign('count',$count);
        $this->assign('feedback_list',$feedback_list);
        return $this->fetch();
    }



    public function feedback_edit(Request $request){
        $id=$request->param('id');
        $feedback=FeedbackModel::with('user')->where(['id'=>$id])->find();
        $feedback=$feedback->hidden(['user.password']);
        $this->assign('feedback',$feedback);
        return $this->fetch();
    }


    public function feedback_del(Request $request){
        $id=$request->param('id');
        $feedback=FeedbackModel::get($id);
        $feedback->is_delete=0;
        $feedback->save();
        $feedback->delete();

    }
    public function no_del(){
        FeedbackModel::update(['is_delete'=>1,'delete_time'=>NULL],['is_delete'=>0]);
    }



    public function feedback_delAll(){

        $idsArr=input('post.ids/a');
        foreach($idsArr as $value){
            $feedback=FeedbackModel::get($value);
            $feedback->is_delete=0;
            $feedback->save();
            $feedback->delete();

        }


        exit(json_encode(array('status'=>1,'message'=>'删除成功')));

    }
}