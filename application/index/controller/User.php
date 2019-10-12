<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/29
 * Time: 11:13
 */

namespace app\index\controller;

use app\index\controller\Base as BaseController;

use app\index\model\User as UserModel;
use app\index\model\UserAddress as UserAddressModel;
use app\index\model\UserAddress;
use think\Db;
use think\Request;
use app\index\model\Product as ProductModel;
class User extends BaseController
{
    public function goComment(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $data=input('post.');
        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $result=$user->comments()->save($data);
        if($result){
            return [
                'status'=>1,
                'message'=>'评论成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'评论失败'
            ];
        }
    }


    public function personal(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }

        $user=session('user_info');
        unset($user['password']);
        $this->assign('user',$user);
      return  $this->fetch();
    }

    public function address(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }

        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids])->select();
        $this->assign('visitProduct',$visitProduct);


        $uid=$this->getUid();
        $address=UserAddress::where(['user_id'=>$uid])->select();
        $this->assign('address',$address);
        return $this->fetch('address');
    }

    public function addressAdd(){
        return $this->fetch('select');

    }

    public function saveAddress(){

        $uid=$this->getUid();
        $data=input('post.');
        $user=UserModel::get($uid);
        $result=$user->address()->save($data);
        if($result){
            return [
                'status'=>1,
                'message'=>'添加成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'添加失败'
            ];
        }
    }

    public function addressUpdate(){
      $uid=$this->getUid();
        $address_id=input('put.address');
        Db::startTrans();
        $reult1=UserAddress::where(['user_id'=>$uid])->update(['primary'=>0]);
        $reult2=UserAddress::where(['user_id'=>$uid,'id'=>$address_id])->update(['primary'=>1]);
        if($reult1 && $reult2){
            Db::commit();
            return [
                'status'=>1,
                'message'=>'修改成功'
            ];
        }else{
            Db::rollback();
            return [
                'status'=>0,
                'message'=>'修改失败'
            ];
        }

    }

    public function message(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        return  $this->fetch();
    }


    public function editAddress(){
        $id=input('get.id');
        $uid=$this->getUid();
        $address=UserAddressModel::findOne($id,$uid);
        $this->assign('address',$address);
        return $this->fetch();
    }

    public function saveRegister(){
        $data=input('post.');
        $result=$this->validate($data,'User.register');
//        $validate	=	Loader::validate('User.register');
//        $result=$validate->batch()->check($data);

        if(true!==$result){
            return  [
                'status'=>0,
                'message'=>$result
//                'message'=>$validate->getError()
            ];
        }
        $datas=Request::instance()->except('rePassword');
        $datas['password']=md5($datas['password']);
        $newUser=UserModel::create($datas);
        if($newUser){
            return  [
                'status'=>1,
                'message'=>'注册成功,请重新登入'
            ];
        }else{
            return  [
                'status'=>0,
                'message'=>'注册失败'
            ];
        }
    }


    //修改个人信息
    public function changeBase(){
        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $userBase=$user->hidden(['password','avatar_url','create_time','avatar_url']);
        $this->assign('userBase',$userBase);
        return $this->fetch();
    }

    public function saveChangeBaseMessage(){
        $data=input('post.');
        $result=$this->validate($data,'User.editBase');
        if(true!==$result){
            return [
                'status'=>0,
                'message'=>$result
            ];
        }
        $uid=$this->getUid();
        $result=UserModel::where(['id'=>$uid])->update($data);
        if($result){
            return [
                'status'=>1,
                'message'=>'修改信息成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'修改信息失败'
            ];
        }
    }



    public function changePassword(){
        return $this->fetch();
    }

    public function saveChangePassword(){
        $data=input('post.');
        $validate=new changePasswordValidate();
        $result=$validate->check($data);
        if(!$result){
            return [
                'status'=>0,
                'message'=>$validate->getError()
            ];

        }
        $uid=$this->getUid();
        $userPassword=UserModel::where(['id'=>$uid])->value('password');
        $password=md5(input('post.password'));
        if($password!==$userPassword){
            return [
                'status'=>0,
                'message'=>'旧密码与原密码不一致'
            ];

        }
        $result=UserModel::where(['id'=>$uid])->update(['password'=>md5(input('post.newPassword'))]);
        if($result){
            return [
                'status'=>1,
                'message'=>'修改密码成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'修改密码失败'
            ];
        }
    }

    public function changeAvatar(){
        $uid=$this->getUid();
        $avatar_url=UserModel::get($uid)->value('avatar_url');
        $this->assign('avatar_url',$avatar_url);
        return $this->fetch();
    }

    public function uploadAvatar(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
//        unlink(ROOT_PATH . 'public' . DS . 'user_avatar'.'/20190806\1bb9fffffb4f1219ae3e7a7e0c4fb504.jpg');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>200000,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'user_avatar');

        if($info){
            $image = Image::open(ROOT_PATH . 'public' . DS . 'user_avatar'.'/'.$info->getSaveName());
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
            $image->thumb(150, 150,Image::THUMB_CENTER)->save(ROOT_PATH . 'public' . DS . 'user_avatar'.'/'.$info->getSaveName());

            //写入数据库
            $uid=$this->getUid();
            $user=UserModel::get($uid);
            if($user->avatar_url){
                if(file_exists(ROOT_PATH.'public'.$user->avatar_url)){
                    unlink(ROOT_PATH.'public'.$user->avatar_url);
                }

            }
            $user->avatar_url='/user_avatar/'.$info->getSaveName();
            $result=$user->save();

            if($result){
//                    $upload='/user_avatar/';
                return ['status'=>1,'message'=>'修改头像成功'];
//                    return ['status'=>1,'message'=>'上传头像成功','avatar_url'=>$upload.$info->getSaveName()];
            }else{
                return ['status'=>0,'message'=>'上传失败，未知错误'];
            }

        }else{
            // 上传失败获取错误信息
            return ['status'=>0,'message'=>$file->getError()];
        }
    }

}