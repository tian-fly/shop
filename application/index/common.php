<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/11
 * Time: 12:49
 */
use app\index\model\Standard as StandardModel;

function getStandardImg($sid){
    $standard=StandardModel::get($sid,'centerImg');
    return $standard->centerImg->img_url;
}

function getStandard($sid){
    $standard=StandardModel::get($sid);
    return $standard->color.$standard->memory;
}

function getStandardPrice($sid){
   return StandardModel::where(['id'=>$sid])->value('price');
}