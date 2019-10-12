<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
use think\Route;


//获取网站主页
Route::get('/','index/index/index');

//获取Banner
Route::get('index/banner/:id','index/Banner/getBanner');


//获取theme
Route::get('index/theme','index/Theme/getAllTheme');
//获取某theme下的product
Route::get('index/theme/:id','index/Theme/getOneThemeProducts');



//获取product
Route::group('index/product',function(){
    Route::get('/productPicture','index/Product/getProductPicture');
    Route::get('/productPrice','index/Product/getProductPrice');
    Route::get('/hot','index/Product/getHotProducts');
    Route::get('/rencent','index/Product/getRencentlyProducts');
    Route::get('/test','index/Product/test');
    Route::get('/search','index/Product/search');
    Route::get('/:id','index/Product/getOne');


});


//获取所有category
Route::get('index/category','index/category/getAllCategory');
Route::get('index/category/:id','index/category/getOneCategoryProducts');



//用户评论
Route::post('user/comment','index/user/goComment');

//获取用户数据
Route::get('index/changeBase','index/User/changeBase');
Route::get('index/changePassword','index/User/changePassword');
Route::get('index/changeAvatar','index/User/changeAvatar');

//修改用户数据
Route::post('personal/saveChangeBaseMessage','home/User/saveChangeBaseMessage');
Route::post('personal/saveChangePassword','home/User/saveChangePassword');


//购物车

Route::group('index/car',function(){
    Route::get('','index/car/index');
    Route::get('/add','index/car/addToCar');
    Route::get('/delete','index/car/deleteForCar');
    Route::post('/deleteAll','index/car/deleteAllForCar');
    Route::get('/null','index/car/destoryForCar');
    Route::get('/addNum','index/car/addNumByCar');
    Route::get('/reduceNum','index/car/reduceNumByCar');
    Route::get('/inputNum','index/car/inputNumByCar');
});



//订单

Route::group('index/order',function(){
    Route::get('/pre','index/order/preOrder');
    Route::get('/look','index/order/lookOrder');
    Route::post('/toOrder','index/order/order');
    Route::get('','index/order/showOrders');
    Route::delete('/delete','index/order/deleteFromeOrders');
    Route::delete('/deleteAll','index/order/deleteAllOrders');
    Route::delete('/null','index/order/orderNull');
});



//打开用户登入页面
Route::get('start_login','index/login/index');
//用户登入验证
Route::post('login','index/login/login');
//获取验证码
Route::get('captcha','/index/login/captcha');

//用户退出
Route::post('logout','index/login/logout');

//用户反馈
Route::get('start_feedback','index/feedback/index');
Route::post('feedback/send','index/feedback/send');


//打开用户注册页面
Route::get('start_register','index/login/register');
//用户注册
Route::post('register','index/User/saveRegister');

//pay
Route::group('index/pay',function(){
    Route::get('','index/pay/index');
    Route::get('/test','index/pay/test');
    Route::get('/add','index/car/addToCar');
    Route::get('/delete','index/car/deleteForCar');
    Route::post('/toPay','index/pay/pay');
    Route::post('/notify','index/pay/notifyMethod');
    Route::get('/returnfy','index/pay/returnfyMethod');
});


Route::get('index/personal','index/user/personal');
Route::get('index/message','index/user/personal');
Route::get('index/address','index/user/address');
Route::get('index/address/add','index/user/addressAdd');
Route::post('index/address/save','index/user/saveAddress');
Route::put('index/address/update','index/user/addressUpdate');