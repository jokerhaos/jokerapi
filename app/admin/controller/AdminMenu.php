<?php
/*
 * @Description  : 菜单管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminMenuValidate;
use app\admin\service\AdminMenuService;

class AdminMenu
{
    /**
     * 菜单列表
     *
     * @method GET
     * 
     * @return json
     */
    public function menuList()
    {
        $data = AdminMenuService::findList();
        return success($data);
    }

    /**
     * 菜单信息
     *
     * @method GET
     * 
     * @return json
     */
    public function menuInfo()
    {
        $param['admin_menu_id'] = Request::param('admin_menu_id/d', '');
        validate(AdminMenuValidate::class)->scene('menu_id')->check($param);
        $data = AdminMenuService::info($param['admin_menu_id']);
        return success($data);
    }

    /**
     * 菜单添加
     *
     * @method POST
     * 
     * @return json
     */
    public function menuAdd()
    {
        $param = array(
            'admin_menu_name'       => Request::post('admin_menu_name/s', ''),
            'admin_menu_title'      => Request::post('admin_menu_title/s', ''),
            'admin_menu_icon'       => Request::post('admin_menu_icon/s', ''),
            'admin_menu_path'       => Request::post('admin_menu_path/s', ''),
            'admin_menu_sort'       => Request::post('admin_menu_sort/d', ''),
            'admin_menu_pid'        => Request::post('admin_menu_pid/d', ''),
            'admin_menu_level_path' => Request::post('admin_menu_level_path/s', '0'),
        );
        validate(AdminMenuValidate::class)->scene('menu_add')->check($param);
        $data = AdminMenuService::add($param);
        return success($data);
    }

    /**
     * 菜单修改
     *
     * @method POST
     * 
     * @return json
     */
    public function menuEdit()
    {
        $param = array(
            'admin_menu_id'    => Request::post('admin_menu_id/d', ''),
            'admin_menu_name'  => Request::post('admin_menu_name/s', ''),
            'admin_menu_title' => Request::post('admin_menu_title/s', ''),
            'admin_menu_icon'  => Request::post('admin_menu_icon/s', ''),
            'admin_menu_path'  => Request::post('admin_menu_path/s', ''),
            'admin_menu_sort'  => Request::post('admin_menu_sort/d', ''),
        );
        validate(AdminMenuValidate::class)->scene('menu_edit')->check($param);
        $data = AdminMenuService::edit($param);
        return success($data);
    }

    /**
     * 菜单删除
     *
     * @method POST
     * 
     * @return json
     */
    public function menuDel()
    {
        $param['ids'] = Request::param('ids/s', '');
        validate(AdminMenuValidate::class)->scene('menu_dele')->check($param);
        $data = AdminMenuService::dele($param['ids']);
        return success($data);
    }
}
