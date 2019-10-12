<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/3
 * Time: 21:54
 */

namespace app\index\controller;
use app\admin\model\Standard;
use app\index\controller\Base as BaseController;
use app\index\model\Order as OrderModel;
use app\lib\exception\Miss;
use app\lib\exception\Product;
use think\Db;
use app\index\model\Product as ProductModel;

class Pay extends  BaseController
{
    public function index(){
        $id=input('get.id');
        $uid=$this->getUid();
        $order=OrderModel::with('products')->where(['user_id'=>$uid,'id'=>$id])->find();
        if(!$order){
            throw new Miss([
                'msg'=>'请求错误'
            ]);
        }
        $order['name']="手机购买";
        $this->assign('order',$order);
        return $this->fetch();
    }



    public function pay()
    {
        $uid=$this->getUid();
        $id=input('post.id');
        $order=OrderModel::with('products')->where(['user_id'=>$uid,'id'=>$id])->find();
        if(!$order){
            throw new Miss([
                'msg'=>'请求支付错误'
            ]);
        }

        static $countarr=[];
        foreach($order['products'] as $item){
            $countarr[]=$item['pivot']['count'];
        }
        static $sidarr=[];
        foreach($order['products'] as $item){
            $sidarr[]=$item['pivot']['standard_id'];
        }
        for($i=0;$i<count($sidarr);$i++){
            $stock=Standard::where(['id'=>$sidarr[$i]])->value('stock');
            if($stock<$countarr[$i]){
                throw new Product([
                    'msg'=>'库存量不足,请重新下单',

                ]);
            }
        }


        $orderDesc='';
        foreach($order['products'] as $item){
            $orderDesc.=getStandard($item['pivot']['standard_id']).'x'.$item['pivot']['count'].'/';
        }
        header("Content-type:text/html;charset=utf-8");
        $config = array(
            //应用ID,您的APPID。
            'app_id' => "2016101400685881",

            //商户私钥
            'merchant_private_key' => "MIIEowIBAAKCAQEAxsQN4jsXEWKxVB/AHPY6KL0MrRQALZwLctkXPXpn4YGj+dy/uH2ftqGpHlwHr6Si1clVKYEZFFKl+e+JIbmeY88QUR3WLRF3YgMFCSbB+fqRWBmsWf6z8sr8NfdBADYKS7KTLx/vGyEEcBm9Wwg5NzAlpksdc+6zNyLMECjk/ezT04nxtXSrKMfDTJHqDuhRGMX3zp/gnzPbdvK0kBPJ42ZAivGwKkSk3AeTofSLCkR2/q5epwNjhrciZa+/uK9EykF2E7noSL/KDMhiUIyKdWfHPIyqDs8YKxoPSZYvHfeOyeL4YfyZgaOFNXK2APclgqkettDzFhopXI6dHaoLvQIDAQABAoIBAF9pTwzQtpMG3/50u0BrxaE2lnYiiq9aH3jC0tAVCPaLx42yNGm4C8mcMlU7cgkTK4MaAQJKUSKbRccC/72rn2djxv5ZJy09HCR1NJ6e9zAq4kf7EuukQvcCDy1Mgew7BJgvoU1Ws+0+3SV+hZHEEcr3FquLlRjIdUi7MF91ce6dPr+jEefke6ulzCu0Tbxarxe+5UyJQh3ZkeUXM0KPzYSSJfyGitCU1RujrCbJ33CApH/soEATp00ggngIftJ302QUpbFQc5SlHymmZLetJr081UqkyTW7BdL4ZRrvGo8N1azRub+dJOWPtMjpTDQh1ogXE0XAjJe4NVDpn2KvAfUCgYEA5MEo00Ys+BmIMgLFn/Bjkc/VqvLutx1Bc854IVl++crRAvSomeiCANg6mkrDNnj81eGLgRA80OLtV4yujlaGVVE0EWYSBUrY8oIM+0vybgkO5775OUlKubed+TLkBrnsouPwE6DoDjVOZFm4TOWf6tPXUpXxltN7S6Eyliq9uL8CgYEA3nCGQzNX+mik11Ua+e8v3mAGavSe/FGapsBi4CXVapv5mMVwPf/yS/63a1P4UyPvPS4FSLj6i1/uOC4Ck9UGT6r78rpqExNxvmo53ZDMFrDzTbn0xGGFSLMNvXnVlbOZvPao/dsa50/ofShmVQtPMz7oGXo7kIBUVXNulBF5/oMCgYAKqrcsoukV6JrhOh/dBWifNAHSpuFayJJ0w/v2EiZJn5t/d8kk5CKrx2l0KGhR8fJYRtwqeIdddjd7DaRWHtLEx7SV2xycApF7PXU9gp0bZHC9fbpBYZmKb3V+WVEovyK5tcdMIwSvJO0y4LwnWc3LNXWk9Dj/v3zQWgPx3KxcIQKBgQCUFpfcP19wD6DG1xr5kDrvMkCzjh4WX4G1SFnLXoTB0AuQoMmEDVTTMUYNhz7IoyDQO0Y7TyNGDNy8vCztHKJyAaRwyZh7ELPmEDRsBM1Kwg2JDqcc4svoRYR9Q5JlcseEXTbOosM7giCGypGuRrQ4qsW8yHrFThpXNV1F6IiuXwKBgGfSnquMdfYULWscS0hNe9FS2rOXn7+XFxbnWgxqjPDVGpZkxLjWTJmS6f1HUqxDhGTCuLBE18E5p/WwCWVgjktb0CYPxhT8eYEi4MgG0Ai6VRB9m/qaE4z3uQBYRoPNvZ6IqkxpQN/qCo+1qwmw/TrPjvz9rIgYJHAZx/w0dUqB",

            //异步通知地址
            'notify_url' => "http://www.shop.com/index/pay/notify",

            //同步跳转
            'return_url' => "http://www.shop.com/index/pay/returnfy",

            //编码格式
            'charset' => "UTF-8",

            //签名方式
            'sign_type' => "RSA2",

            //支付宝网关
            'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

            //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
            'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnYX9/HEUYFHrIN4+Y2jsxGR+dls9Y0iU86iejofI4So/LOmuevh0jJbU6FoxVh4mBPk48HBGwT8lJ+Upncq7gZH55slEdRZTRnv0Js89NOu0HKpI3CHq1Jy4R7x0gxy7oIwTU5ulNV6mj+jzLueXQzKCA7xghUIuq9dFbbJCsu9j69j/QgJjrni33w+Y8SMj6GA9jT7PHcApiQKvWLJ5Ju1CLhAV2rv8vWy/2iYAflDv+a8SsYcQo58QdianmL0RD8eIrmpJhAOpt8GnBMgG5T0qrepOt+PeRjhlF8lTuOcnLH69AuQA010oxlbt9nDhyJZLyREIvBeL+jEt977bewIDAQAB",
        );
        if ($order['order_no']) {
            include_once VENDOR_PATH . '/alipay/config.php';
            include_once VENDOR_PATH . '/alipay/pagepay/service/AlipayTradeService.php';
            include_once VENDOR_PATH . '/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $order['order_no'];

            //订单名称，必填
            $subject = '手机购买';

            //付款金额，必填
            $total_amount = $order['total_price'];

            //商品描述，可空
            $body = $orderDesc;
            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);

            $aop = new \AlipayTradeService($config);

            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder, $config['return_url'], $config['notify_url']);

            //输出表单
            var_dump($response);
        }
    }

public function test(){
    $order_no='A20191006715571570376716';
    $order=OrderModel::with('products')->where(['order_no'=>$order_no])->find();
    static $countarr=[];
    foreach($order['products'] as $item){
        $countarr[]=$item['pivot']['count'];
    }
    static $sidarr=[];
    foreach($order['products'] as $item){
        $sidarr[]=$item['pivot']['standard_id'];
    }
   for($i=0;$i<count($sidarr);$i++){
       $stock=Standard::where(['id'=>$sidarr[$i]])->value('stock');
       Standard::where(['id'=>$sidarr[$i]])->update(['stock'=>($stock-$countarr[$i])]);
   }
}



    public function notifyMethod()
    {


        $out_trade_no = $_POST['out_trade_no'];
//        OrderModel::where(['order_no'=>$out_trade_no])->update(['status'=>1]);
//        $trade_status = $_POST['trade_status'];
        if($_POST['trade_status'] == 'TRADE_FINISHED') {

//        OrderModel::where(['order_no'=>$out_trade_no])->update(['status'=>1]);

        }
        else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {

            Db::startTrans();
            try{
                $order=OrderModel::with('products')->where(['order_no'=>$out_trade_no])->find();
                static $countarr=[];
                foreach($order['products'] as $item){
                    $countarr[]=$item['pivot']['count'];
                }
                static $sidarr=[];
                foreach($order['products'] as $item){
                    $sidarr[]=$item['pivot']['standard_id'];
                }
                for($i=0;$i<count($sidarr);$i++){
                    $stock=Standard::where(['id'=>$sidarr[$i]])->value('stock');
                    Standard::where(['id'=>$sidarr[$i]])->update(['stock'=>($stock-$countarr[$i])]);
                    $sell=Standard::where(['id'=>$sidarr[$i]])->value('sell');
                    Standard::where(['id'=>$sidarr[$i]])->update(['sell'=>($sell+$countarr[$i])]);
                    $product_id=Standard::where(['id'=>$sidarr[$i]])->value('product_id');
                    $psell=ProductModel::where(['id'=>$product_id])->value('sell');
                    Product::where(['id'=>$product_id])->update(['sell'=>$psell]);
                }

                OrderModel::where(['order_no'=>$out_trade_no])->update(['status'=>1]);
                Db::commit();
            }catch(\Exception $e){
                dump($e->getMessage());
                Db::rollback();
            }


        }
//        if ($post['trade_status'] == "TRADE_SUCCESS") {
//
//            OrderModel::where(['order_no'=>$post['out_trade_no']])->update(['status'=>1]);
////            Db::name('order')->where('out_trade_no',$post['out_trade_no'])->update(array('pay_status'=>'success'));
//            //操作数据库 修改状态
//            echo "SUCCESS";
//        }
        echo "SUCCESS";
        //写在文本里看一下参数


    }
    /**
     * 同步方法
     * @return [type] [description]
     */
    public function returnfyMethod()
    {
        $out_trade_no=input('get.out_trade_no');
        OrderModel::where(['order_no'=>$out_trade_no])->update(['status'=>1]);

//        $post = input('param.');
//        //同步跳转地址
//        var_dump($post);
        echo "<h1 align='center' style='color: green;margin-top: 200px;'>支付成功<a href='http://www.shop.com/index/order'>返回订单首页</a></h1>";
        exit();
    }
}