<?php
namespace app\index\controller;
use app\index\model\Product;
use think\Controller;
use app\index\model\Product as ProductModel;
use app\index\model\Category as CategoryModel;
use think\captcha\Captcha;
class Index extends  Controller
{
    public function index()
    {
        $productsH=ProductModel::getHot();
        $this->assign('productsH',$productsH);

        $productsR=Product::getRencently();
        $this->assign('productsR',$productsR);

        $categories=CategoryModel::all();
        $this->assign('categories',$categories);
      return $this->fetch();

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
}
