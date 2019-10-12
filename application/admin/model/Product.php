<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/7/28
 * Time: 10:07
 */

namespace app\admin\model;

use app\admin\model\Base as BaseModel;
class Product extends BaseModel

{

    protected $hidden=['centerImg_id','is_hot','category_id','create_time','update_time','delete_time'];

    protected $dateFormat="Y-m-d H:i:s";


    public function getStatusAttr($value){
        $status=[
            0=>'下架',
            1=>'在架'
        ];
        return $status[$value];
    }

    public static function getAll(){
        return self::with(['category','standards'])->paginate(7);
    }

    public static function getAllByCategory($cid){
        return self::where(['category_id'=>$cid])->paginate(7);
    }



    public static function getProductDetail($id){
//        return self::get($id,['centerImg','images.image']);
        return self::with(['standards','images.image','standards.centerImg','param'])->where(['id'=>$id])->find();
    }


    public static function getHot(){
        return self::with(['centerImg'])->where(array('is_hot'=>1))->select();
    }

    public static function getRencently(){
        return self::with(['centerImg'])->order('create_time desc')->select();
    }


    public function centerImg(){
        return $this->belongsTo('Image','centerImg_id','id');
    }
    public function images(){
        return $this->hasMany('Product_Image','product_id','id');
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id','id');
    }

    public function standards(){
        return $this->hasMany('Standard','product_id','id');
    }

    public function param(){
        return $this->hasOne('Param','product_id','id');

    }

    public static function search($l,$r,$content){
        $contentArr=array('like','%'.$content.'%');
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'name'=>$contentArr])->paginate(7);
    }

    public static function search1($l,$r){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr])->paginate(7);
    }

    public static function search2($content){
        $contentArr=array('like','%'.$content.'%');
        return self::where(['name'=>$contentArr])->paginate(7);
    }

    public static function searchByCategory($l,$r,$content,$cid){
        $contentArr=array('like','%'.$content.'%');
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'name'=>$contentArr,'category_id'=>$cid])->paginate(7);
    }

    public static function searchByCategory1($l,$r,$cid){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'category_id'=>$cid])->paginate(7);
    }

    public static function searchByCategory2($content,$cid){
        $contentArr=array('like','%'.$content.'%');
        return self::where(['name'=>$contentArr,'category_id'=>$cid])->paginate(7);
    }
}