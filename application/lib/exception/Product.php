<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/8
 * Time: 19:18
 */

namespace app\lib\exception;
use app\lib\exception\Base as BaseException;


class Product extends BaseException
{
    public $code=402;
    public $msg='请求的页面错误';
    public $errorCode=30000;
}