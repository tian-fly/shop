<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 9:59
 */

namespace app\index\controller;
use app\index\controller\Base as BaseController;
use app\index\model\Theme as ThemeModel;
use app\index\validate\IDNumber as IDNumberValidate;
use app\lib\exception\Miss;

class Theme extends BaseController
{
   public function getAllTheme(){
     $themes=ThemeModel::getAll();
     return $themes;
   }

    public function getOneThemeProducts($id){
        $validate=new IDNumberValidate();
        $validate->checked();
        $theme=ThemeModel::getOne($id);
        if(!$theme){
            throw new Miss([
               'msg'=>'您找的主题不存在...',
                'errorCode'=>20001
            ]);
        }
        return $theme;
    }
}