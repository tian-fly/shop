<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 10:24
 */

namespace app\lib\exception;
use think\Exception;

class Base extends Exception
{
    public $code=400;
    public $msg='参数错误';
    public $errorCode=800;
    public $shouldToClient = true;
    public function __construct($param=[])
    {
        if(!is_array($param)){
            return;
        }
        if(array_key_exists('code',$param)){
            $this->code=$param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg=$param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
            $this->errorCode=$param['errorCode'];
        }
    }


}