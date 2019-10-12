<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/6/16
 * Time: 10:41
 */
namespace app\admin\controller;
use think\Controller;
use traits\model\SoftDelete;
use app\admin\model\User as UserModel;
use app\admin\model\Passage as PassageModel;
use think\Request;
class User extends Base{
    use SoftDelete;
    public function user_list(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $count=UserModel::count();
        $user_list=UserModel::allUsers();
        $user_list=$user_list->hidden(['password']);
        $this->assign('count',$count);
        $this->assign('user_list',$user_list);
        return $this->fetch();
    }
    public function user_status(Request $request){
        $id=$request->param('id');
        $user=UserModel::get($id);

        if($user->getData('status') == 1){
            $user->status=0;
            $user->save();
            $user->passages()->update(['status'=>0]);
        }else{
            $user->status=1;
            $user->save();
            $user->passages()->update(['status'=>1]);
        }
    }
    public function user_edit(Request $request){
        $id=$request->param('id');
        $user=UserModel::get(['id'=>$id]);
        $this->assign('user',$user);
        return $this->fetch();
    }
    public function save_menu(Request $request){
        $id=$request->param('id');
        $data=$request->except('id');
        if($id>0){
            $update=UserModel::update($data,['id'=>$id]);
            if($update){
                exit(json_encode(array('status'=>1,'message'=>'修改成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'修改失败')));

            }
        }else{
            $insert=UserModel::create($data);
            if($insert){
                exit(json_encode(array('status'=>1,'message'=>'添加成功')));

            }else{
                exit(json_encode(array('status'=>0,'message'=>'添加失败')));
            }
        }
    }
    public function user_del(Request $request){
        $uid=$request->param('id');
        $user=UserModel::get($uid);
        $user->is_delete=0;
        $user->save();

//        if($user->getData('avatar_url')){
//            if(file_exists(ROOT_PATH.'public'.$user->getData('avatar_url'))){
//                unlink(ROOT_PATH.'public'.$user->getData('avatar_url'));
//            }
//        }
//        $this->clear(ROOT_PATH.'public/user_uploads/'.$uid);

        $user->delete();


        $user->passages()->update(['is_delete'=>0]);
        $user->passages()->delete();
    }
    public function no_del(){
        UserModel::update(['is_delete'=>1],['is_delete'=>0]);
        UserModel::update(['delete_time'=>NULL],['is_delete'=>0]);


        PassageModel::update(['is_delete'=>1],['is_delete'=>0]);
        PassageModel::update(['delete_time'=>NULL],['is_delete'=>0]);
    }

    public function search(){
        $time=input('get.time');
        $content=input('get.content');

        if($time){
            $timeArr=explode('~',$time);
            foreach($timeArr as &$value){
                $value=strtotime(trim($value));
            }
        }
        if($content && $time){
            $users=UserModel::search($timeArr[0],$timeArr[1],$content);
        }elseif(!$content && $time){

            $users=UserModel::search1($timeArr[0],$timeArr[1]);
        }elseif(!$time && $content){
            $users=UserModel::search2($content);
        }else{
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('请输入查找用户...');history.back()</script>";
            exit();
        }



        $count=count($users);

        if($count==0){
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('没有找到相关的用户...');history.back()</script>";
            exit();
        }


        $this->assign('count',$count);

        $this->assign('user_list',$users);


        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        return $this->fetch('user_list');
    }

    public function searchUser(){
        $uid=input('get.uid');

        $user=UserModel::get($uid);
        $this->assign('user_list',$user);

        $this->assign('count',1);
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        return $this->fetch('user_list');

    }

    public function user_delAll(){

        $idsArr=input('post.ids/a');
        foreach($idsArr as $value){
            $user=UserModel::get($value);
            $user->is_delete=0;
            $user->save();
            $user->delete();
            $user->passages()->update(['is_delete'=>0]);
            $user->passages()->delete();
        }
        exit(json_encode(array('status'=>1,'message'=>'删除成功')));

    }

}