<?php
/*
 * @Description  : 角色管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-30
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminRoleValidate;
use app\admin\service\AdminRoleService;

class AdminRole
{
    /**
     * 角色列表
     *
     * @method GET
     * 
     * @return json
     */
    public function roleList()
    {
        $page  = Request::post('page/d', 1);
        $limit = Request::post('limit/d', 10);
        $getAll = Request::post('get_all/b', false);
        $field = Request::post('field/s', "*"); //寻找字段
        $param = array(
            'admin_role_code' => Request::post("admin_role_code/s",''),
            'admin_role_name' => Request::post("admin_role_name/s",''),
            'admin_role_status' => Request::post("admin_role_status/d",''),
            'start_time' => Request::post("start_time/d",''),
            'end_time' => Request::post("end_time/d",'')
        );
        $data = AdminRoleService::findList($param, $page, $limit, $field,$getAll);

        return success($data);
    }


    /**
     * 角色添加
     *
     * @method POST
     * 
     * @return json
     */
    public function roleAdd()
    {
       
        $param = array(
            'admin_role_code' => Request::post("admin_role_code/s",''),
            'admin_role_name' => Request::post("admin_role_name/s",''),
            'admin_role_desc' => Request::post("admin_role_desc/s",''),
        );
        validate(AdminRoleValidate::class)->scene('role_add')->check($param);

        $data = AdminRoleService::add($param);

        return success($data);
    }

    /**
     * 角色修改
     *
     * @method POST
     * 
     * @return json
     */
    public function roleEdit()
    {
        $param = array(
            'admin_role_id'    => Request::post("admin_role_id/s",''),
            'admin_role_name' => Request::post("admin_role_name/s",''),
            'admin_role_desc' => Request::post("admin_role_desc/s",''),
        );
        validate(AdminRoleValidate::class)->scene('role_edit')->check($param);
        $data = AdminRoleService::edit($param);
        return success($data);
    }

    /**
     * 角色删除
     *
     * @method POST
     * 
     * @return json
     */
    public function roleDel()
    {
        $param['admin_role_id'] = Request::post('admin_role_id/d', '');
        validate(AdminRoleValidate::class)->scene('role_dele')->check($param);
        $data = AdminRoleService::dele($param['admin_role_id']);
        return success($data);
    }

    /**
     * 角色状态改变
     *
     * @method POST
     * 
     * @return json
     */
    public function roleStatusUpdate()
    {
        $param['admin_role_id'] = Request::post('admin_role_id/d', '');
        $param['admin_role_status'] = Request::post('admin_role_status/d', '');

        validate(AdminRoleValidate::class)->scene('role_id')->check($param);
        $data = AdminRoleService::roleStatusUpdate($param);
        return success($data);
    }

    /**
     * 角色分配菜单
     *
     * @method POST
     * 
     * @return json
     */
    public function roleMenu()
    {
        $param['admin_role_id'] = Request::post('admin_role_id/d', '');
        $param['admin_menu_id'] = Request::post('admin_menu_id/s', '');
        $param['admin_menu_checked_id'] = Request::post('admin_menu_checked_id/s', '');
        validate(AdminRoleValidate::class)->scene('role_menu')->check($param);
        $data = AdminRoleService::roleMenu($param);
        return success($data);
    }

    /**
     * 角色分配权限
     *
     * @method POST
     * 
     * @return json
     */
    public function roleAuth()
    {
        $param['admin_role_id'] = Request::post('admin_role_id/d', '');
        $param['admin_auth_id'] = Request::post('admin_auth_id/s', '');
        validate(AdminRoleValidate::class)->scene('role_auth')->check($param);
        $data = AdminRoleService::roleAuth($param);
        return success($data);
    }
}
