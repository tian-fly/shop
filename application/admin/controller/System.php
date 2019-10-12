<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/28
 * Time: 17:04
 */

namespace app\admin\controller;


class System extends Base
{
    public function index(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);
        return $this->fetch('index/index');
    }
    public function clear_logs(){
        if($this->clear(ROOT_PATH.'runtime'.DS.'log')===true){
            echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>";

            echo "<script>alert('清除日志成功');history.back();</script>";
            exit();
        }else{
            echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>";

            echo "<script>alert('清除日志失败');history.back();</script>";
            exit();
        }
    }
    public function clear_cache(){
        if($this->clear(ROOT_PATH.'runtime'.DS.'cache')===true){
            ;
            echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>";

            echo "<script charset='utf-8'>alert('清除缓存成功');history.back();</script>";
            exit();
        }else{
            echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>";

            echo "<script charset='utf-8'>alert('清除缓存失败');history.back();</script>";
            exit();
        }
    }
    public function clear($path,$delDir=true){

        if (is_dir($path)) {
            $handle = opendir($path);
            if ($handle) {
                while (false !== ( $item = readdir($handle) )) {

                    if ($item != "." && $item != ".."){
                        is_dir("$path/$item") ? $this->clear("$path/$item", true) : unlink("$path/$item");
                    }

                }
                closedir($handle);
                if ($delDir){
                    return rmdir($path);

                }
            }
        } else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return false;
            }
        }

        clearstatcache();
    }
}