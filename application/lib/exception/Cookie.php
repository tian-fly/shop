<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/2
 * Time: 20:46
 */

namespace app\lib\exception;

use app\lib\exception\Base as BaseException;
class Cookie extends  BaseException
{
    public $code=501;
    public $msg='cookie异常';
    public $errorCode=6000;

}