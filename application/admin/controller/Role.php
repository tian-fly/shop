<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/11
 * Time: 21:39
 */

namespace app\admin\controller;
use app\admin\model\Role as RoleModel;
use app\admin\model\Menu as MenuModel;
use think\Request;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base as BaseController;
class Role extends BaseController
{
    public function role_list(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $count=RoleModel::count();
        $role_list=RoleModel::all();
        $this->assign('count',$count);
        $this->assign('role_list',$role_list);
        return $this->fetch();
    }
    public function role_status(Request $request){
        $id=$request->param('id');
        $role=RoleModel::get($id);

        if($role->getData('status') == 1){
//            RoleModel::update(['status'=>0],['id'=>$id]);
            $role->status=0;
            $role->save();
            $role->admin()->update(['status'=>0]);
        }else{
//            RoleModel::update(['status'=>1],['id'=>$id]);
            $role->status=1;
            $role-save();
            $role->admin()->update(['status'=>1]);
        }
    }
    public function role_edit(Request $request){
        $id=$request->param('id');
        $role=RoleModel::get(['id'=>$id]);
        $menu=MenuModel::all();
        $menu_list=$this->menu_tree($menu);
        $this->assign('menu_list',$menu_list);
        $this->assign('role',$role);
        return $this->fetch();
    }



    public function test(){
        $menu=MenuModel::all();
        $menu_list=$this->menu_tree($menu);
       return $menu_list;
    }
    private function menu_tree($date,$pid=0,$floor=1){
        static $arr=array();
        foreach($date as $value){
            if($value['pid']==$pid){
                $value['floor']=$floor;
                $arr[]=$value;
                $this->menu_tree($date,$value['id'],$floor+1);
            }
        }
        return $arr;
    }
    public function save_role(){
        $id=$_POST['id'];
        $map['name']=$_POST['name'];
        /*$right=$_POST['right/a'];
        $map['right']=json_encode($right);*/
        $map['right']=json_encode($_POST['right']);
//        $map['right']=json_encode($_POST['right']);
        if($id>0){
            $update=RoleModel::update($map,['id'=>$id]);
            if($update){
                exit(json_encode(array('status'=>1,'message'=>'修改成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'修改失败')));

            }
        }else{
            $insert=RoleModel::create($map);
            if($insert){
                exit(json_encode(array('status'=>1,'message'=>'添加成功')));

            }else{
                exit(json_encode(array('status'=>0,'message'=>'添加失败')));
            }
        }
    }
    public function role_del(Request $request){
        $id=$request->param('id');
        $role=RoleModel::get(['id'=>$id]);


        /*  RoleModel::update(['is_delete'=>0],['id'=>$id]);
          RoleModel::destroy($id);*/
        $role->is_delete=0;
        $role->save();
        $role->delete();

        $role->admin()->update(['is_delete'=>0]);
        $role->admin()->delete();



    }
    public function no_del(){
        RoleModel::update(['is_delete'=>1,'delete_time'=>NULL],['is_delete'=>0]);
//        RoleModel::update(['delete_time'=>NULL],['is_delete'=>0]);

        AdminModel::update(['is_delete'=>1,'delete_time'=>NULL],['is_delete'=>0]);
//        AdminModel::update(['delete_time'=>NULL],['is_delete'=>0]);
    }
}