<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/10
 * Time: 21:52
 */

namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\model\Standard as StandardModel;
use think\Image;
use app\admin\model\Image as ImageModel;
class Standard extends BaseController
{
    public function picture(){
        $id=input('get.id');
        $standard=StandardModel::get($id,['centerImg','product']);
        $this->assign('standard',$standard);
        return $this->fetch('showImg');
    }

    public function test(){


       $str='';
        for($i=0;$i<4;$i++){
          $str.=rand(0,9);
        }
       $hua=imagecreatetruecolor(100,50);
        $whites=imagecolorallocate($hua,255,0,0);
        imagefill($hua,0,0,$whites);
       $white=imagecolorallocate($hua,20,0,0);
        imagestring($hua,5,0,0,$str,$white);
        ob_end_clean();
        header("content-type:image/png");
       imagepng($hua);
        imagedestroy($hua);

    }

    public function uploadPicture(){
        $brand=input('post.brand');
        $name=input('post.name');
        $img_id=input('post.img_id');
        $id=input('post.id');
        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name;

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>2000000,'ext'=>'jpg,png,gif,jpeg'])->move($address);

        if($info){

//            写入数据库
            $img=ImageModel::create(['img_url'=>'/images/'.$brand.'/'.$name.'/'.$info->getSaveName()]);

            $result=StandardModel::where(['id'=>$id])->update(['centerImg_id'=>$img->getData('id')]);

            if($result){
                return ['status'=>1,'message'=>'添加图片成功','img_url'=>$img->getData('img_url')];
            }else{
                return ['status'=>0,'message'=>'上传失败，未知错误'];
            }

        }else{
            // 上传失败获取错误信息
            return ['status'=>0,'message'=>$file->getError()];
        }
    }

    public function changePicture(){

        $brand=input('post.brand');
        $name=input('post.name');
        $img_id=input('post.img_id');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>20000000,'ext'=>'jpg,png,gif,jpeg'])->move($address);

        if($info){
            //写入数据库
            $img=ImageModel::get($img_id);
            if($img->getData('img_url')){
                if(file_exists(ROOT_PATH . 'public' .$img->getData('img_url'))){
                    unlink(ROOT_PATH . 'public' .$img->getData('img_url'));
                }
            }
            $img->img_url='/images/'.$brand.'/'.$name.'/'.$info->getSaveName();
            $result=$img->save();

            if($result){
                return ['status'=>1,'message'=>'修改图片成功','img_url'=>$img->getData('img_url')];
            }else{
                return ['status'=>0,'message'=>'上传失败，未知错误'];
            }

        }else{
            // 上传失败获取错误信息
            return ['status'=>0,'message'=>$file->getError()];
        }
    }



}