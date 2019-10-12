<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/6/16
 * Time: 10:41
 */
namespace app\admin\controller;
use think\Controller;

use app\admin\model\Menu as MenuModel;
use think\Request;
class Menu extends Base{
    public function menu_list(){
        $pid=isset($_GET['pid'])?$_GET['pid']:0;
        $count=MenuModel::where(['pid'=>$pid])->count();
        $menu_list=MenuModel::where(['pid'=>$pid])->order(['ord asc'])->paginate(8);
        if(count($menu_list)==0){
            echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>";
            echo "<script charset='utf-8'>alert('当前菜单么有子菜单');history.back();</script>";
            exit();
        }
        $this->assign('pid',$pid);
        $this->assign('count',$count);
        $this->assign('menu_lists',$menu_list);

        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);




        return $this->fetch();
    }
    public function menu_status(Request $request){
        $id=$request->param('id');
        $menu=MenuModel::get($id);

        if($menu->getData('status') == 1){
            MenuModel::update(['status'=>0],['id'=>$id]);
        }else{
            MenuModel::update(['status'=>1],['id'=>$id]);
        }
    }
    public function menu_edit(Request $request){
        $id=$request->param('id');
        $menu=MenuModel::get(['id'=>$id]);
        $menu_list_zero=MenuModel::where(['pid'=>0])->order(['ord asc'])->select();
        $this->assign('menu_list_zero',$menu_list_zero);
        $this->assign('menu',$menu);
        return $this->fetch();
    }
    public function save_menu(Request $request){
        $id=$request->param('id');
        $data=$request->except('id');
        if($id>0){
            $update=MenuModel::update($data,['id'=>$id]);
            if($update){
                exit(json_encode(array('status'=>1,'message'=>'修改成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'修改失败')));

            }
        }else{
            $insert=MenuModel::create($data);
            if($insert){
                exit(json_encode(array('status'=>1,'message'=>'添加成功')));

            }else{
                exit(json_encode(array('status'=>0,'message'=>'添加失败')));
            }
        }
    }
    public function menu_del(Request $request){
        $id=$request->param('id');
        MenuModel::update(['is_delete'=>0],['id'=>$id]);
        MenuModel::destroy($id);
    }
    public function no_del(){
        MenuModel::update(['is_delete'=>1],['is_delete'=>0]);
        MenuModel::update(['delete_time'=>NULL],['is_delete'=>0]);
    }
    public function menu_delAll(){

        $idsArr=input('post.ids/a');

        foreach($idsArr as $value){
            $menu=MenuModel::get($value);
            $menu->is_delete=0;
            $menu->save();
            $menu->delete();
            $menus=MenuModel::all();
            foreach($menus as $values){
                if($values['pid']==$value){
                    $menuSon=MenuModel::get($values['id']);
                    $menuSon->is_delete=0;
                    $menuSon->save();
                    $menuSon->delete();
                }
            }
        }
        exit(json_encode(array('status'=>1,'message'=>'删除成功')));

    }



}