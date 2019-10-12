<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/7
 * Time: 21:12
 */

namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\model\Product as ProductModel;
use app\admin\model\Category;
use app\admin\model\ProductImage;
use app\admin\model\Standard;
use app\admin\model\Param;
use think\Db;
use think\Request;
use think\Validate;
use app\admin\model\Image as ImageModel;
class Product extends BaseController
{
    public function product_list(){
        $this->no_login();
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $products=ProductModel::getAll();

        foreach($products as &$item){
            $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
            $item['sell']=$sell;
        }

        $count=count($products);
        $this->assign('count',$count);
        $this->assign('product_list',$products);
        $this->assign('menu','商品管理');
        $this->assign('menuSon','商品列表');
        return $this->fetch();
    }

    public function add(){
        $this->no_login();
        $category=Category::all();
        $this->assign('category',$category);
        $menu_name=$this->menu_lists();
        $category=Category::all();
        $this->assign('category',$category);
        $this->assign('menu_list',$menu_name);
        $this->assign('menu','商品管理');
        $this->assign('menuSon','商品列表');
        return $this->fetch();
    }

    public function changeImg(){
        $cid=input('get.cid');
        $images=ImageModel::where(['category_id'=>$cid])->select();
        if($images){
            return [
                'status'=>1,
                'message'=>$images
            ];
        }else{
            return [
                'status'=>0,
            ];
        }
    }

    public function getImg(){
        $id=input('get.id');
        $image=ImageModel::where(['id'=>$id])->value('img_url');
        if($image){
            return [
                'status'=>1,
                'message'=>$image
            ];
        }else{
            return [
                'status'=>0,
            ];
        }
    }

    public function product_status(Request $request){
        $id=$request->param('id');
        $product=ProductModel::get($id);

        if($product->getData('status') == 1){
           $product->status=0;
            $product->save();
            $product->standards()->update(['status'=>0]);
        }else{
            $product->status=1;
            $product->save();
            $product->standards()->update(['status'=>1]);
        }
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
            $products=ProductModel::search($timeArr[0],$timeArr[1],$content);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }elseif(!$content && $time){

            $products=ProductModel::search1($timeArr[0],$timeArr[1]);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }elseif(!$time && $content){
            $products=ProductModel::search2($content);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }else{
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('请输入查找商品...');history.back()</script>";
            exit();
        }



        $count=count($products);

        if($count==0){
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('没有找到相关的商品...');history.back()</script>";
            exit();
        }


        $this->assign('count',$count);

        $this->assign('product_list',$products);


        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        $this->assign('menu','商品管理');
        $this->assign('menuSon','商品列表');

        return $this->fetch('product_list');
    }

    public function searchByCategory(){
        $time=input('get.time');
        $content=input('get.content');
        $cid=input('get.cid');
        if($time){
            $timeArr=explode('~',$time);
            foreach($timeArr as &$value){
                $value=strtotime(trim($value));
            }
        }
        if($content && $time){
            $products=ProductModel::searchByCategory($timeArr[0],$timeArr[1],$content,$cid);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }elseif(!$content && $time){

            $products=ProductModel::searchByCategory1($timeArr[0],$timeArr[1],$cid);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }elseif(!$time && $content){
            $products=ProductModel::searchByCategory2($content,$cid);
            foreach($products as &$item){
                $sell=Standard::where(['product_id'=>$item['id']])->sum('sell');
                $item['sell']=$sell;
            }
        }else{
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('请输入查找商品...');history.back()</script>";
            exit();
        }



        $count=count($products);

        if($count==0){
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('没有找到相关的商品...');history.back()</script>";
            exit();
        }


        $this->assign('count',$count);

        $this->assign('product_list',$products);


        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        $this->assign('menu','商品管理');
        $this->assign('menuSon','商品列表');

        return $this->fetch('product_list');
    }

    public function standards()
    {
        $this->no_login();
        $pid = input('get.pid');
        $product=ProductModel::where(['id'=>$pid])->find();
        $standards = Standard::where(['product_id'=>$pid])->paginate(7);
        $count = count($standards);
        if ($count == 0) {
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('该商品暂未添加规格');history.back()</script>";
            exit();
        }
        $this->assign('count', $count);
        $this->assign('standard_list', $standards);
        $this->assign('product',$product);
        $this->assign('menu', '商品管理');
        $this->assign('menuSon', '商品列表');
        $this->assign('menuSun', '规格列表');
        $menu_name = $this->menu_lists();
        $this->assign('menu_list', $menu_name);
        return $this->fetch();
    }

    public function product_del(){
        $id=input('get.id');
        $product=ProductModel::get($id);
        if($product->delete()){
            $product->standards()->delete();
        }
    }

    public function save(){
        $product['brand']=input('post.brand');
        $product['name']=input('post.name');
        $product['introduce']=input('post.introduce');
        $product['category_id']=input('post.category_id');
        $product['status']=1;

        $param['model']=input('post.model');
        $param['color']=input('post.color');
        $param['ram']=input('post.ram');
        $param['rom']=input('post.rom');
        $param['CPU']=input('post.CPU');
        $param['Ka']=input('post.Ka');

        $colors=input('post.colors/a');
        $memories=input('post.memory/a');
        $prices=input('post.prices/a');
        $stocks=input('post.stocks/a');

        Db::startTrans();
        try{
            $result1=ProductModel::create($product);
            $result1->param()->save($param);
            for($i=0;$i<count($colors);$i++){
                $result1->standards()->save(['color'=>$colors[$i],'memory'=>$memories[$i],'price'=>$prices[$i],'stock'=>$stocks[$i],'sell'=>0,'status'=>1]);
            }
            Db::commit();
            return [
              'status'=>1,
                'message'=>'添加成功'
            ];
        }catch(\Exception $e){
            Db::rollback();
            return [
              'status'=>0
            ];
        }



    }

    public function picture(){
        $id=input('get.id');
        $product=ProductModel::where(['id'=>$id])->with(['images.image'])->find();
        $this->assign('product',$product);
        return $this->fetch();
    }

    public function uploads(){
        $brand=input('post.brand');
        $name=input('post.name');
        $id=input('post.id');
        // 获取表单上传文件 例如上传了001.jpg
        $files[]= request()->file('file');

        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name.'/body';

        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>20000000,'ext'=>'jpg,png,gif,jpeg'])->move($address);
//            if($files){
//                return ['status'=>0,'message'=>'增加图片成功'];
//            }
            if($info){
                //写入数据库
                $img=ImageModel::create(['img_url'=>'/images/'.$brand.'/'.$name.'/'.'body/'.$info->getSaveName()]);
                $product=ProductModel::get($id);
                $result= $product->images()->save(['img_id'=>$img->getData('id')]);

                if($result){
                    return ['status'=>1,'message'=>'增加图片成功'];
                }else{
                    return ['status'=>0,'message'=>'上传失败，未知错误'];
                }
                return ['status'=>1,'message'=>'增加图片成功'];
            }else{
                // 上传失败获取错误信息
                return ['status'=>0,'message'=>$file->getError()];
            }
        }
    }

    public function delete(){
        $iid=input('get.iid');
        $pid=input('get.pid');
        $img=ImageModel::get($iid);
        if($img->getData('img_url')){
            if(file_exists(ROOT_PATH . 'public' .$img->getData('img_url'))){
                unlink(ROOT_PATH . 'public' .$img->getData('img_url'));
            }
            if($img->delete()){
               $productImg=ProductImage::where(['img_id'=>$iid,'product_id'=>$pid])->find();
                $productImg->delete();
                return ['status'=>1,'message'=>'删除成功'];
            }else{
                return ['status'=>0,'message'=>'删除失败成功'];

            }
        }else{
            return ['status'=>0,'message'=>'删除失败成功'];
        }
    }

    public function test(){
        $brand=input('post.brand');
        $name=input('post.name');
        $id=input('post.id');

        // 获取表单上传文件 例如上传了001.jpg
        $files = request()->file('file');
        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name;

        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>20000000,'ext'=>'jpg,png,gif,jpeg'])->move($address);

            if($info){
                //写入数据库
                $img=ImageModel::create(['img_url'=>'/images/'.$brand.'/'.$name.'/'.$info->getSaveName()]);
                $product=ProductModel::get($id);
                $result= $product->images()->save(['img_id'=>$img->getData('id')]);

                if($result){
                    return ['status'=>1,'message'=>'增加图片成功'];
                }else{
                    return ['status'=>0,'message'=>'上传失败，未知错误'];
                }

            }else{
                // 上传失败获取错误信息
                return ['status'=>0,'message'=>$file->getError()];
            }
        }

    }


    public function select(){
        $id=input('get.id');
        $product=ProductModel::get($id,['centerImg']);
        $this->assign('product',$product);
        return $this->fetch();
    }

    public function uploadPicture(){
        $brand=input('post.brand');
        $name=input('post.name');
        $id=input('post.id');
        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name;

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>2000000,'ext'=>'jpg,png,gif,jpeg'])->move($address);

        if($info){

//            写入数据库
            $img=ImageModel::create(['img_url'=>'/images/'.$brand.'/'.$name.'/'.$info->getSaveName()]);

            $result=ProductModel::where(['id'=>$id])->update(['centerImg_id'=>$img->getData('id')]);

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
        $address=ROOT_PATH . 'public' . DS . 'images'.'/'.$brand.'/'.$name.'/head';
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
            $img->img_url='/images/'.$brand.'/'.$name.'/head/'.$info->getSaveName();
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