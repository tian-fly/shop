<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/7
 * Time: 21:12
 */

namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\model\Order as OrderModel;
use app\admin\model\OrderProduct;
use think\Db;
use think\Request;
class Order extends BaseController
{
    public function noGetMoney(){
        $this->no_login();
        $status0=OrderModel::noGetMoney();
        $count=count($status0);
        $this->assign('count',$count);
        $this->assign('status0',$status0);
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $this->assign('orderStatus',0);
        $this->assign('menu','订单管理');
        $this->assign('menuSon','未支付订单');
        return $this->fetch('1');
    }
    public function getMoney(){
        $status1=OrderModel::getMoney();
        $count=count($status1);
        $this->assign('count',$count);
        $this->assign('status1',$status1);
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $this->assign('orderStatus',1);
        $this->assign('menu','订单管理');
        $this->assign('menuSon','已支付订单');
        return $this->fetch('2');
    }
    public function getProduct(){
        $status2=OrderModel::getProduct();
        $count=count($status2);
        $this->assign('count',$count);
        $this->assign('status2',$status2);
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $this->assign('orderStatus',2);
        $this->assign('menu','订单管理');
        $this->assign('menuSon','已发货订单');
        return $this->fetch('3');
    }
    public function successTrade(){
        $status3=OrderModel::successTrade();
        $count=count($status3);
        $this->assign('count',$count);
        $this->assign('status3',$status3);
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $this->assign('orderStatus',3);
        $this->assign('menu','订单管理');
        $this->assign('menuSon','交易成功订单');
        return $this->fetch('4');
    }

    public function order_edit(Request $request){
        $id=$request->param('id');
        $order=OrderModel::get(['id'=>$id]);
        $this->assign('order',$order);
        return $this->fetch('edit');
    }
    public function save_order(Request $request){
        $id=$request->param('id');
        $data=$request->except('id');
        $update=OrderModel::update($data,['id'=>$id]);
        if($update){
            return [
                'status'=>1,
                'message'=>'修改成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'修改失败'
            ];
        }
    }
    public function order_del(Request $request){
        $id=$request->param('id');
        $order=OrderModel::get($id);
        $order->delete();
        OrderProduct::where(['order_id'=>$id])->delete();

    }

    public function order_delAll(){

        $idsArr=input('param.ids/a');
        foreach($idsArr as $value){
            $order=OrderModel::get($value);
            if($order->delete()){
                OrderProduct::where(['order_id'=>$order->id])->delete();
                return [
                    'status'=>1,
                    'message'=>'删除成功'
                ];
            }else{
                return [
                    'status'=>0,
                    'message'=>'删除失败'
                ];
            }
        }

    }

    public function search(){
        $time=input('get.time');
        $content=input('get.content');
        $orderStatus=input('get.orderStatus');
        if($time){
            $timeArr=explode('~',$time);
            foreach($timeArr as &$value){
                $value=strtotime(trim($value));
            }
        }
        if($content && $time){
            $orders=OrderModel::search($timeArr[0],$timeArr[1],$content);
        }elseif(!$content && $time){

            $orders=OrderModel::search1($timeArr[0],$timeArr[1]);
        }elseif(!$time && $content){
            $orders=OrderModel::search2($content);
        }else{
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('请输入查找内容...');history.back()</script>";
            exit();
        }



        $count=count($orders);

        if($count==0){
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('没有找到相关的内容...');history.back()</script>";
            exit();
        }


        $this->assign('count',$count);

        if($orderStatus==0){
            $this->assign('status0',$orders);
            $this->assign('orderStatus',0);
            $this->assign('menu','订单管理');
            $this->assign('menuSon','未支付订单');
        }elseif($orderStatus==1){
            $this->assign('status0',$orders);
            $this->assign('orderStatus',1);
            $this->assign('menu','订单管理');
            $this->assign('menuSon','已支付订单');
        }elseif(($orderStatus==2)){
            $this->assign('status0',$orders);
            $this->assign('orderStatus',2);
            $this->assign('menu','订单管理');
            $this->assign('menuSon','已发货订单');
        }else{
            $this->assign('status0',$orders);
            $this->assign('orderStatus',3);
            $this->assign('menu','订单管理');
            $this->assign('menuSon','交易成功订单');
        }

        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        return $this->fetch('1');
    }
}