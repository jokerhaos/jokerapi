<?php
/*
 * @Description  : 权限管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-26
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminAuthValidate;
use app\admin\service\AdminAuthService;

class AdminAuth
{
    /**
     * 权限列表
     *
     * @method POST
     * 
     * @return json
     */
    public function authList()
    {
        $page = Request::post('page/d', 1); //当前页
        $limit = Request::post('limit/d', 10); //每页数量
        $field = Request::post('field/s', "*"); //寻找字段
        $getAll = Request::post('get_all/b', false);
        //接收参数post
        $param = array(
            'admin_auth_name' => Request::post('admin_auth_name/s', ''), //名字
            'admin_auth_path' => Request::post('admin_auth_path/s', '') //路径
        );
        $data = AdminAuthService::findList($param,$page,$limit,$field,$getAll);
        return success($data);
    }

    /**
     * 权限添加
     *
     * @method POST
     * 
     * @return json
     */
    public function authAdd()
    {
        //接收参数post
        $param = array(
            'admin_auth_name' => Request::post('admin_auth_name/s', ''), //名字
            'admin_auth_path' => Request::post('admin_auth_path/s', ''), //账号
            'admin_auth_desc' => Request::post('admin_auth_desc/s', ''), //账号
        );
        validate(AdminAuthValidate::class)->scene('auth_add')->check($param);
        $data = AdminAuthService::add($param);
        return success($data);
    }

    /**
     * 权限修改
     *
     * @method GET|POST
     * 
     * @return json
     */
    public function authEdit()
    {
        //接收参数post
        $param = array(
            'admin_auth_id'   => Request::post('admin_auth_id/d', ''), //ID
            'admin_auth_name' => Request::post('admin_auth_name/s', ''), //名字
            'admin_auth_path' => Request::post('admin_auth_path/s', ''), //账号
            'admin_auth_desc' => Request::post('admin_auth_desc/s', ''), //账号
        );
        validate(AdminAuthValidate::class)->scene('auth_edit')->check($param);
        $data = AdminAuthService::edit($param);
        return success($data);
    }

    /**
     * 权限删除
     *
     * @method POST
     * 
     * @return json
     */
    public function authDel()
    {
        $param['admin_auth_id'] = Request::param('admin_auth_id/d', '');
        validate(AdminAuthValidate::class)->scene('auth_dele')->check($param);
        $data = AdminAuthService::dele($param['admin_auth_id']);
        return success($data);
    }
}
