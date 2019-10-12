<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 18:17
 */

namespace app\admin\controller;


class Index extends Base
{
    public function index(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        return $this->fetch();
    }
}