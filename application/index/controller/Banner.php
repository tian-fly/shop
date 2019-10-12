<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 10:01
 */

namespace app\index\controller;
use app\index\controller\Base as BaseController;
use app\index\validate\IDNumber as IDNumberValidate;
use app\index\model\Banner as BannerModel;
use app\lib\exception\Miss as MissException;
use think\Request;
class Banner extends BaseController
{
  public function getBanner(){
      $id=Request::instance()->route('id');
      $validate=new IDNumberValidate();
      $validate->checked();

      $banner=BannerModel::getBanner($id);
      if(!$banner){
          throw new MissException([
              'msg'=>'你找的Banner不存在....',
              'errorCode'=>10001
          ]);
      }
      return $banner;

  }
}