<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/2
 * Time: 20:08
 */

namespace app\index\controller;
use app\index\model\Product as ProductModel;
use app\index\model\Standard as StandardModel;
class Car extends Base
{
    //查看购物车
    public function index(){
        $result=$this->no_login();
        if($result!='true'){
            return $result;
        }
        $cars=$this->highToCar();
        array_pop($cars);
//        return json_encode($cars);
        if(count($cars)>0){
            $total_price=0;
            foreach($cars as $value){
                $total_price+=$value['total_one_price'];
            }
            $this->assign('total_price',$total_price);
            $this->assign('products',$cars);
        }else{
            $this->assign('total_price',0);
            $this->assign('products',[]);
        }

        $visit=cookie('visit');
        $ids=array('in',$visit);
        $visitProduct=ProductModel::with('centerImg')->where(['id'=>$ids])->select();
        $this->assign('visitProduct',$visitProduct);

        return $this->fetch();
    }



    //添加到购物车
    public function addToCar()
    {
        $g_id = input('get.id');
        $g_num = input('get.num');
        $g_standardId = input('get.standard_id');

        $car_gids = cookie('car_ids');
        $car_gnums = cookie('car_nums');
        $car_standardIds = cookie('car_standards');

        $car_gids_arr = explode('&', $car_gids);
        $car_gnums_arr = explode('&', $car_gnums);
        $car_standardIds_arr = explode('&', $car_standardIds);
        if (count($car_gids_arr) > 1) {
            if (in_array($g_id, $car_gids_arr) && in_array($g_standardId, $car_standardIds_arr) ) {
                    $g_standardId = array_search($g_standardId, $car_standardIds_arr);
                    $car_gnums_arr[$g_standardId] += $g_num;
                    $c_nums = implode('&', $car_gnums_arr);
                    cookie('car_ids', $car_gids, 60 * 60 * 24 * 7);
                    cookie('car_nums', $c_nums, 60 * 60 * 24 * 7);
                    cookie('car_standards', $car_standardIds, 60 * 60 * 24 * 7);

                    return [
                        'status' => 1,
                        'message' => '添加购物车成功'
                    ];
            }else{
                $car_gids .= $g_id . '&';
                $car_gnums .= $g_num . '&';
                $car_standardIds .= $g_standardId . '&';
                cookie('car_ids', $car_gids, 60 * 60 * 24 * 7);
                cookie('car_nums', $car_gnums, 60 * 60 * 24 * 7);
                cookie('car_standards', $car_standardIds, 60 * 60 * 24 * 7);
                return [
                    'status' => 1,
                    'message' => '添加购物车成功'
                ];
            }
        } else {
            $car_gids .= $g_id . '&';
            $car_gnums .= $g_num . '&';
            $car_standardIds .= $g_standardId . '&';
            cookie('car_ids', $car_gids, 60 * 60 * 24 * 7);
            cookie('car_nums', $car_gnums, 60 * 60 * 24 * 7);
            cookie('car_standards', $car_standardIds, 60 * 60 * 24 * 7);
            return [
                'status' => 1,
                'message' => '添加购物车成功'
            ];
        }

    }

    public function test(){
        $str='1,1,8';
        $arr=explode(',',$str);
        static $products=array();
        foreach($arr as $item){
            $products[]=ProductModel::where(['id'=>$item])->find();
        }
//        $c_gids_sql_arr=array('in','1,1,8');
//        $products=ProductModel::where(['id'=>$c_gids_sql_arr])->select();
        return json_encode($products);
        return json_encode(cookie('car_nums'));
    }

    //从购物车中删除某件商品
    public function deleteForCar(){
        $index=input('get.index');
        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');

        $car_gids_arr=explode('&',$car_gids);
        $car_gnums_arr=explode('&',$car_gnums);
        $car_standardIds_arr=explode('&',$car_standardIds);

        if($car_gids_arr[$index]){
            unset($car_gids_arr[$index]);
            unset($car_gnums_arr[$index]);
            unset($car_standardIds_arr[$index]);

            if(count($car_gids_arr)>1){
                $c_nums=implode('&',$car_gnums_arr);
                $c_gids=implode('&',$car_gids_arr);
                $c_standards=implode('&',$car_standardIds_arr);
                cookie('car_ids',$c_gids,60*60*24*7);
                cookie('car_nums',$c_nums,60*60*24*7);
                cookie('car_standards',$c_standards,60*60*24*7);

                $cars=$this->highToCar();
                $total_price=0;
                foreach($cars as $value){
                    $total_price+=$value['total_one_price'];
                }

                return [
                    'status'=>1,
                    'message'=>'移除商品成功',
                    'total_price'=>$total_price
                ];

            }else{
                cookie('car_ids',null);
                cookie('car_nums',null);
                cookie('car_standards',null);

                return [
                    'status'=>1,
                    'message'=>'移除商品成功',
                    'total_price'=>0
                ];
            }



            }else{
            return [
                'status'=>0,
                'message'=>'删除的商品不在购物车中......'
            ];

        }
    }



    //清空购物车
    public function destoryForCar(){
        cookie('car_ids',null);
        cookie('car_nums',null);
        cookie('car_standards',null);
        return [
            'status'=>1,
            'message'=>'清空购物车成功'
        ];
    }

    //增加购物车某件商品数量
    public function addNumByCar(){
        $index=input('get.index');

        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');


        $car_gnums_arr=explode('&',$car_gnums);


        $car_gnums_arr[$index]+=1;
        $car_gnums=implode('&',$car_gnums_arr);

        cookie('car_ids',$car_gids,60*60*24*7);
        cookie('car_nums',$car_gnums,60*60*24*7);
        cookie('car_standards',$car_standardIds,60*60*24*7);

        $cars=$this->highToCar();
        $total_price=0;
        foreach($cars as $value){
            $total_price+=$value['total_one_price'];
        }

        return[
          'status'=>1,
            'total_one_price'=>$cars[$index]['total_one_price'],
            'total_price'=>$total_price
        ];

    }

    //减少购物车某件商品数量
    public function reduceNumByCar(){
        $index=input('get.index');

        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');


        $car_gnums_arr=explode('&',$car_gnums);


        $car_gnums_arr[$index]-=1;
        $car_gnums=implode('&',$car_gnums_arr);

        cookie('car_ids',$car_gids,60*60*24*7);
        cookie('car_nums',$car_gnums,60*60*24*7);
        cookie('car_standards',$car_standardIds,60*60*24*7);

        $cars=$this->highToCar();
        $total_price=0;
        foreach($cars as $value){
            $total_price+=$value['total_one_price'];
        }

        return[
            'status'=>1,
            'total_one_price'=>$cars[$index]['total_one_price'],
            'total_price'=>$total_price
        ];
    }

    //更新购物车某件商品数量
    public function inputNumByCar(){
        $index=input('get.index');
        $num=input('get.num');

        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');

        $car_gnums_arr=explode('&',$car_gnums);

        $car_gnums_arr[$index]=$num;
        $car_gnums=implode('&',$car_gnums_arr);

        cookie('car_ids',$car_gids,60*60*24*7);
        cookie('car_nums',$car_gnums,60*60*24*7);
        cookie('car_standards',$car_standardIds,60*60*24*7);

        $cars=$this->highToCar();
        $total_price=0;
        foreach($cars as $value){
            $total_price+=$value['total_one_price'];
        }

        return[
            'status'=>1,
            'total_one_price'=>$cars[$index]['total_one_price'],
            'total_price'=>$total_price
        ];

    }

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

    function deleteAllForCar(){
        $index=input('post.ids/a');

        $car_gids=cookie('car_ids');
        $car_gnums=cookie('car_nums');
        $car_standardIds=cookie('car_standards');

        $car_gids_arr=explode('&',$car_gids);
        $car_gnums_arr=explode('&',$car_gnums);
        $car_standardIds_arr=explode('&',$car_standardIds);
        foreach($index as $item){
            unset($car_gids_arr[$item]);
            unset($car_gnums_arr[$item]);
            unset($car_standardIds_arr[$item]);
        }
        if(count($car_gids_arr)>0){
            $car_gids=implode('&',$car_gids_arr);
            $car_gnums=implode('&',$car_gnums_arr);
            $car_standardIds=implode('&',$car_standardIds_arr);

            cookie('car_ids',$car_gids,60*60*24*7);
            cookie('car_nums',$car_gnums,60*60*24*7);
            cookie('car_standards',$car_standardIds,60*60*24*7);

            return [
                'status'=>1,
                'message'=>'丢弃商品成功'
            ];
        }else{
            cookie('car_ids',null);
            cookie('car_nums',null);
            cookie('car_standards',null);
            return [
                'status'=>1,
                'message'=>'清空购物车成功'
            ];
        }
    }

}