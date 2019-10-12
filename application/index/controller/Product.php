<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 10:06
 */

namespace app\index\controller;
use app\index\controller\Base as BaseController;
use app\index\model\Product as ProductModel;
use app\index\validate\IDNumber as IDNumberValidate;
use app\lib\exception\Miss;
use app\index\model\Standard;
class Product extends BaseController
{
    public function getOne($id){
       (new IDNumberValidate())->checked();
        $productDetail=ProductModel::getProductDetail($id);

//         $sell=Standard::where(['product_id'=>$productDetail['id']])->sum('sell');
//        $productDetail['sell']=$sell;

         if(!$productDetail){
            throw new Miss([
               'msg'=>'您所找的商品不存在、、、',
                'errorCode'=>'40001'
            ]);
        }

        $this->visitCookie($id);


//        return $productDetail['standards'];
        $color=array();
        foreach($productDetail['standards'] as $item){
            array_push($color,$item['color']);
        }
        $color=array_unique($color);

        $memory=array();
        foreach($productDetail['standards'] as $item){
            array_push($memory,$item['memory']);
        }
        $memory=array_unique($memory);

        $productDetail['color']=$color;
        $productDetail['memory']=$memory;
//        return json_encode($productDetail);
        $this->assign('productDetail',$productDetail);


        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids])->select();
        $this->assign('visitProduct',$visitProduct);

        return $this->fetch('index');
    }
    public function getHotProducts(){
      $hotProducts=ProductModel::getHot();
       return $hotProducts;
    }

    public function getRencentlyProducts(){
        $rencentlyProducts=ProductModel::getRencently();
        return $rencentlyProducts;
    }

    public function test(){
        return cookie('visit');
    }



    public function getProductPicture(){
        $pid=input('get.pid');
        $color=input('get.color');
        $memory=input('get.memory');
        $product=ProductModel::get($pid);
        $standard=$product->standards()->with('centerImg')->where(['color'=>$color,'memory'=>$memory])->find();
        return [
            'status'=>1,
            'message'=>$standard['centerImg']['img_url'],
            'sid'=>$standard->getData('id')
        ];
    }

    public function  getProductPrice(){
        $pid=input('get.pid');
        $color=input('get.color');
        $memory=input('get.memory');
        $product=ProductModel::get($pid);
        $standard=$product->standards()->with('centerImg')->where(['color'=>$color,'memory'=>$memory])->find();
        return [
            'status'=>1,
            'price'=>$standard->getData('price'),
            'stock'=>$standard->getData('stock'),
            'sid'=>$standard->getData('id')
        ];

        }

    public function visitCookie($id){
        $visit=cookie('visit');
        $visit_arr=explode(',',$visit);
        if(count($visit_arr)>1){
            if(!in_array($id,$visit_arr)){
                $visit.=$id.',';
                cookie('visit',$visit,60*60*24);
            }else{
                cookie('visit',$visit,60*60*24);
            }

        }else{
            $visit.=$id.',';
            cookie('visit',$visit,60*60*24);
        }
    }

    public function search(){
        $product=input('get.product');
        $products=ProductModel::search($product);
        $this->assign('products',$products);

        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids,'status'=>1])->select();
        $this->assign('visitProduct',$visitProduct);


        return $this->fetch();
    }
}