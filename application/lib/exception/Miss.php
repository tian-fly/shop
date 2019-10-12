<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 11:22
 */

namespace app\lib\exception;

use app\lib\exception\Base as BaseException;
class Miss extends BaseException
{
    public $code=404;
    public $msg='请求的页面不存在';
    public $errorCode=10000;
}