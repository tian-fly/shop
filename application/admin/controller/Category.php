<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/9
 * Time: 23:08
 */

namespace app\admin\controller;
use app\admin\controller\Base as BaseController;
use app\admin\model\Category as CategoryModel;
use app\admin\model\Product as ProductModel;
use think\Db;

class Category extends BaseController
{
    public function category_list()
    {
        $this->no_login();
        $menu_name = $this->menu_lists();
        $this->assign('menu_list', $menu_name);
        $categories = CategoryModel::getAll();
        $count = count($categories);
        $this->assign('count', $count);
        $this->assign('category_list', $categories);
        $this->assign('menu', '分类管理');
        $this->assign('menuSon', '分类列表');
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function save()
    {
        $data = input('post.');
        $has = CategoryModel::getByName($data['name']);
        if ($has) {
            return [
                'status' => 0,
                'message' => '分类已存在'
            ];
        }
        $result = CategoryModel::create($data);
        if ($result) {
            return [
                'status' => 1,
                'message' => '添加成功'
            ];
        } else {
            return [
                'status' => 0,
                'message' => '添加失败'
            ];
        }
    }

    public function products()
    {
        $this->no_login();
        $cid = input('get.cid');
        $products = ProductModel::getAllByCategory($cid);
        $count = count($products);
        if ($count == 0) {
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('该分类暂未添加商品');history.back()</script>";
            exit();
        }
        $this->assign('count', $count);
        $this->assign('product_list', $products);
        $this->assign('menu', '分类管理');
        $this->assign('menuSon', '分类列表');
        $this->assign('menuSun', '商品列表');
        $this->assign('cid',$cid);
        $menu_name = $this->menu_lists();
        $this->assign('menu_list', $menu_name);
        return $this->fetch();
    }

    public function category_del()
    {
        $cid = input('get.id');
        $category = CategoryModel::get($cid);
        Db::startTrans();
        try {
            $category->delete();
            $category->products()->delete();
            $products = ProductModel::where(['category_id' => $cid])->select();
            foreach ($products as $item) {
                $item->standards()->delete();
                $item->param()->delete();
            }
            Db::commit();
            return [
                'status'=>1,
                'message'=>'删除成功'
            ];
        }catch(\Exception $e){
            Db::rollback();
            return [
                'status'=>0,
                'message'=>'删除失败'
            ];
        }
    }
}