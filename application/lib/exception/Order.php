<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/7
 * Time: 10:34
 */

namespace app\lib\exception;
use app\lib\exception\Base as BaseException;


class Order extends BaseException
{
    public $code=402;
    public $msg='请求的页面错误';
    public $errorCode=20000;

}