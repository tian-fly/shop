<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/6/10
 * Time: 11:16
 */
namespace app\admin\controller;
use app\admin\model\Menu as MenuModel;
use app\admin\model\Passage;
use app\admin\model\Role as RoleModel;
use app\admin\model\Admin as AdminModel;
use app\admin\model\User as UserModel;
use app\admin\model\Passage as PassageModel;
use think\Controller;
use think\Request;
use think\captcha\Captcha;
use think\Route;
use think\Session;
use app\admin\controller\Base as BaseController;
class Admin extends BaseController{
//    public function test(){
//        dump($_SERVER);
//    }

    public function login(){
//        $this->is_login();
        return $this->fetch();
    }
    public function captcha(){
        $config =    [
            'fontSize'    =>    16,
            'length'      =>    4,
            'useNoise'    =>    false,
            'codeSet'=>'0123456789',
            'imageW'=>100,
            'imageH'=>50,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    public function checkLogin(Request $request){
        $data=$request->param();

        if(!captcha_check($data['code'])){
            exit(json_encode(array('status'=>0,'message'=>'验证码错误')));

        };
        $datas=[
            'username'=>$data['username'],
            'password'=>$data['password'],
        ];
        $rule=[
            'username'=>'require',
            'password'=>'require',
        ];
        $msg=[
            'username.require'=>'名称必须',
            'password.require'=>'密码必须'
        ];
        $result=$this->validate($datas,$rule,$msg);
        if($result){
            $map=[
                'username'=>$data['username'],
                'password'=>$data['password'],
            ];
            $check=AdminModel::get($map);

            if($check){
                if($check->getData('status')==0){
                    exit(json_encode(array('status'=>0,'message'=>'登入失败，该账号已停用')));
                }
                AdminModel::where($map)->update(['login_time'=>time(),'login_ip'=>$_SERVER['REMOTE_ADDR']]);
                $check1=AdminModel::get($map);
                Session::set('admin_id',$check1['id']);
                Session::set('admin_info',$check1);
                exit(json_encode(array('status'=>1,'message'=>'登入成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'登入失败，用户名或密码错误')));
            }
        }else{
            exit(json_encode(array('status'=>0,'message'=>$result)));
        }
    }
    public function logout(){
        AdminModel::update(['login_time'=>time()],['id'=>Session::get('admin_id')]);
        Session::delete('admin_id');
        Session::delete('admin_info');
        AdminModel::destroy(['is_delete'=>0],true);
        MenuModel::destroy(['is_delete'=>0],true);
        RoleModel::destroy(['is_delete'=>0],true);

//
//        $users=UserModel::where(['is_delete'=>0])->select();
//        foreach($users as $value){
//            if($value['avatar_url']){
//                if(file_exists(ROOT_PATH.'public'.$value['avatar_url'])){
//                    unlink(ROOT_PATH.'public'.$value['avatar_url']);
//                }
//            }
//        }
//
//        UserModel::destroy(['is_delete'=>0],true);
//
//
//
//        $passages=PassageModel::where(['is_delete'=>0])->select();
//        foreach($passages as $value){
//            if($value['imagesB']){
//                $p=explode(',',$value['imagesB']);
//                $q=explode(',',$value['imagesS']);
//                foreach($p as $value1){
//                    if(file_exists(ROOT_PATH.'public'.$value1)){
//                        unlink(ROOT_PATH.'public'.$value1);
//                    }
//                }
//                foreach($q as $value2){
//                    if(file_exists(ROOT_PATH.'public'.$value2)){
//                        unlink(ROOT_PATH.'public'.$value2);
//                    }
//                }
//            }
//        }
//
//        Passage::destroy(['is_delete'=>0],true);
        $this->success('退出成功',url('login'));
    }
    public function admin_list(){
       $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        $count=AdminModel::count();
        $admin_list=AdminModel::paginate(7);
        $this->assign('count',$count);
        $this->assign('admin_list',$admin_list);
        return $this->fetch();
    }
    public function admin_del(Request $request){
        $id=$request->param('id');
        AdminModel::update(['is_delete'=>0],['id'=>$id]);
        AdminModel::destroy($id);
    }
    public function no_del(){
        AdminModel::update(['is_delete'=>1,'delete_time'=>NULL],['is_delete'=>0]);
//        AdminModel::update(['delete_time'=>NULL],['is_delete'=>0]);
    }
    public function admin_edit(Request $request){
        $id=$request->param('id');
        $admin=AdminModel::get(['id'=>$id]);
        $this->assign('admin',$admin);
        return $this->fetch();
    }
    public function save_admin(Request $request){
        $id=$request->param('id');
        $data=$request->except('id');
        if($id>0){
            $update=AdminModel::update($data,['id'=>$id]);
            if($update){
                exit(json_encode(array('status'=>1,'message'=>'修改成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'修改失败')));

            }
        }else{
            $insert=AdminModel::create($data);
            if($insert){
                exit(json_encode(array('status'=>1,'message'=>'添加成功')));

            }else{
                exit(json_encode(array('status'=>0,'message'=>'添加失败')));
            }
        }
    }
    public function admin_status(Request $request){
        $id=$request->param('id');
        $admin=AdminModel::get($id);

        if($admin->getData('status') == 1){
            AdminModel::update(['status'=>0],['id'=>$id]);
        }else{
            AdminModel::update(['status'=>1],['id'=>$id]);
        }
    }

}