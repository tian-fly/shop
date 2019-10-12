<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/2
 * Time: 20:09
 */

namespace app\index\controller;

use app\index\controller\Base as BaseController;
use app\index\model\Comment;
use app\index\model\Order as OrderModel;
use app\index\model\OrderProduct;
use app\index\model\Product as ProductModel;
use app\index\model\User;
use app\index\model\UserAddress as UserAddressModel;
use app\index\model\Standard as StandardModel;
use app\lib\exception\Order as OrderException;
use app\lib\exception\Miss;
class Order extends  BaseController
{

   public function preOrder(){
       $uid=$this->getUid();
       $address=UserAddressModel::where(['user_id'=>$uid])->select();
//       return $address;
       $this->assign('address',$address);
       return $this->fetch('pre');
   }

    public function lookOrder(){
        $oid=input('get.id');
        $uid=$this->getUid();
        $order=OrderModel::getOrderByUser($uid,$oid);
        if(!$order){
            throw new OrderException([
                'msg'=>'请求订单页面错误'
            ]);
        }
        $this->assign('orderDetail',$order);
        return $this->fetch('look');
    }

    //查看未支付、已支付、已发货、交易完成的订单
    public function showOrders(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $ordersN=OrderModel::getOrdersByUserNoDeal($uid);
        $total_price=0;
        foreach($ordersN as $item){
            $total_price+=$item['total_price'];
        }
        $this->assign('total_price',$total_price);
        $this->assign('ordersN',$ordersN);

        $ordersD=OrderModel::getOrdersByUserDeal($uid);
        $this->assign('ordersD',$ordersD);

        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids])->select();
        $this->assign('visitProduct',$visitProduct);

        return $this->fetch('index');
    }


    //查看订单详情
    public function getOrderDetail(){
        $o_id=input('get.id');
        $order=OrderModel::get($o_id,'products');
//       return $order;
        $this->assign('order',$order);
        return $this->fetch();
    }

    //下单
    public  function order(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $address_id=input('post.address');
        $remark=input('post.remark');
        $uid=$this->getUid();
        $cars=$this->highToCar();
        array_pop($cars);
        $total_price=0;
        foreach($cars as $value){
            $total_price+=$value['total_one_price'];
        }

        $address=UserAddressModel::where(['id'=>$address_id])->find();

        $data['order_no']=$order_no=$this->getOrderNo();
        $data['user_id']=$uid;

        $data['total_price']=$total_price;

        $data['count']=count($cars);

        $data['remark']=$remark;

        $data['status']=0;

        $data['pre_address']=$address['province'].$address['city'].$address['detail'];

        $data['pre_name']=$address['name'];

        $data['pre_phone']=$address['mobile'];

        $create=OrderModel::create($data);
        $o_id=$create->id;
        if($create){
            $car_gids=cookie('car_ids');
            $car_gnums=cookie('car_nums');
            $car_standardIds=cookie('car_standards');

            $car_gids_arr=explode('&',$car_gids);
            $car_gnums_arr=explode('&',$car_gnums);
            $car_standardIds_arr=explode('&',$car_standardIds);
            $order=OrderModel::get($o_id);

            for($i=0;$i<count($car_gids_arr)-1;$i++){
                $order->products()->attach($car_gids_arr[$i],['count'=>$car_gnums_arr[$i],'standard_id'=>$car_standardIds_arr[$i]]);
            }

            cookie('car_ids',null);
            cookie('car_nums',null);
            cookie('car_standards',null);

            return [
                'status'=>1,
                'message'=>'恭喜您，下单成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'下单失败'
            ];
        }
    }

    //删除订单
    public function deleteOrder(){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $order_id=input('param.id');

        $product_id=input('param.pids');

        $order=OrderModel::get($order_id);
        $delete=$order->delete();
        if($delete){
            for($i=0;$i<count($product_id);$i++){
                $order->products()->detach($product_id[$i]);
            }
            return [
                'status'=>1,
                'message'=>'删除定单成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'删除定单失败'
            ];
        }
    }

    //获取订单号
    private function getOrderNo(){
      $year=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
      return $year[date('Y',time())-2019].date('Ymd',time()).rand(0,100000).time();
    }

   //获取购物车商品
    private function highToCar(){
        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');

        $car_gids_arr=explode('&',$car_gids);
        $car_gnums_arr=explode('&',$car_gnums);
        $car_standardIds_arr=explode('&',$car_standardIds);


        static $products=array();
        foreach($car_gids_arr as $item){
            $products[]=ProductModel::where(['id'=>$item])->find();
        }

        $car_standardIds=implode(',',$car_standardIds_arr);
        $c_standardIds_sql_arr=array('in',$car_standardIds);
        $stanards=StandardModel::where(['id'=>$c_standardIds_sql_arr])->select();
        $stanards=json_decode($stanards,true);

        for($i=0;$i<count($car_gids_arr)-1;$i++){
            $products[$i]['index']=$i;
            $products[$i]['num']=$car_gnums_arr[$i];
            $products[$i]['standard']='颜色：'.$stanards[$i]['color'].'/内存：'.$stanards[$i]['memory'];
            $products[$i]['price']=$stanards[$i]['price'];
            $products[$i]['stock']=$stanards[$i]['stock'];
            $products[$i]['total_one_price']=$stanards[$i]['price']*$products[$i]['num'];
        }
        return $products;
    }

    public function deleteFromeOrders(){
        $oid=input('param.oid');
        $uid=$this->getUid();
        $order=OrderModel::where(['id'=>$oid,'user_id'=>$uid])->find();
        if(!$order){
            throw new Miss([
                'msg'=>'删除订单错误'
            ]);
        }
        if($order->delete()){
            OrderProduct::where(['order_id'=>$order['id']])->delete();
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

    public function deleteAllOrders(){
        $oids=input('param.ids/a');
        $uid=$this->getUid();
        foreach($oids as $item){
            $order=OrderModel::where(['id'=>$item,'user_id'=>$uid])->find();
            if(!$order){
                throw new Miss([
                    'msg'=>'删除订单错误'
                ]);
            }
            if($order->delete()){
                OrderProduct::where(['order_id'=>$order['id']])->delete();
            }else{
                return [
                    'status'=>0,
                    'message'=>'删除失败'
                ];
            }
        }
        return [
            'status'=>1,
            'message'=>'删除成功'
        ];
    }


    public function orderNull(){
        $uid=$this->getUid();
        $orders=OrderModel::where(['user_id'=>$uid])->select();
        if(!$orders){
            throw new Miss([
                'msg'=>'删除订单错误'
            ]);
        }

        foreach($orders as $item){
            $order=OrderModel::where(['id'=>$item['id']])->find();
            if(!$order){
                throw new Miss([
                    'msg'=>'删除订单错误'
                ]);
            }
            if($order->delete()){
                OrderProduct::where(['order_id'=>$order['id']])->delete();
            }else{
                return [
                    'status'=>0,
                    'message'=>'删除失败'
                ];
            }
        }
        return [
            'status'=>1,
            'message'=>'删除成功'
        ];

    }

    public function test(){

//        $order=OrderModel::get(1);
//        $order->products()->attach(1,['count'=>2]);

        $order=OrderModel::get(1);
        $arr=array(1,2);
        for($i=0;$i<count($arr);$i++){
            $order->products()->detach($arr[$i]);
        }


    }

    public function comment(){
        return $this->fetch();
    }

    public function send(){
        $data=input('post.');

        $status=OrderModel::where(['order_no'=>$data['order_no']])->value('status');
        if($status==0){
            return [
                'status'=>0,
                'message'=>'订单未支付，不支持评论'
            ];
        }
        $uid=$this->getUid();
        $comment=Comment::where(['user_id'=>$uid,'product_id'=>$data['id']])->find();
        if($comment){
            return [
                'status'=>0,
                'message'=>'每个用户只可评论一次'
            ];
        }

        $user=User::get($uid);
        $result=$user->comments()->save(['content'=>$data['content'],'standard_id'=>$data['standard_id'],'product_id'=>$data['id'],'count'=>$data['count']]);
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

}