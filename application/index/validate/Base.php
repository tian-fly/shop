<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/27
 * Time: 10:05
 */
namespace app\index\validate;
use think\Validate;
use think\Request;
use app\lib\exception\Param as ParamException;
class Base extends Validate
{
    public function checked(){
        $request=Request::instance();
        $data=$request->param();
        if(!$this->batch()->check($data)){
           throw  new ParamException([
                'msg'=>is_array($this->error)?implode(';',$this->error):$this->error
            ]);
        }
        return true;
    }
}