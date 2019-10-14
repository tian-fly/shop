<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/29
 * Time: 10:10
 */

namespace app\index\controller;
use app\index\model\Category as CategoryModel;
use app\index\controller\Base as BaseController;
use app\index\validate\IDNumber as IDNumberValidate;
use app\lib\exception\Miss as MissException;
use app\index\model\Product as ProductModel;
class Category extends BaseController
{


    public function getAllCategory(){
        $categories=CategoryModel::getAll();
//        return $categories;
        $this->assign('categories',$categories);
        return $this->fetch('index');
    }

    public function getOneCategoryProducts($id){
        (new IDNumberValidate())->checked();
        $category=CategoryModel::getOne($id);
        if(!$category){
            throw new MissException([
               'msg'=>'您找的分类不存在...',
                'errorCode'=>'3001'
            ]);
        }

        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids])->select();
        $this->assign('visitProduct',$visitProduct);


        $categories=CategoryModel::getAll();
        $this->assign('categories',$categories);
        $this->assign('category',$category);
        return $this->fetch('index');
    }
}