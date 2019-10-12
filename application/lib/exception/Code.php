<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/11
 * Time: 19:39
 */

namespace app\lib\exception;

use app\lib\exception\Base as BaseException;
class Code extends BaseException
{
    public $code=401;
    public $msg='有code才能进来哟~~~';
    public $errorCode=4003;




}