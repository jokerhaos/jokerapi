<?php
/*
 * @Description  : 用户管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-26
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminUserValidate;
use app\admin\service\AdminUserService;

class AdminUser
{
    /**
     * 用户列表
     *
     * @method POST
     * 
     * @return json
     */
    public function userList()
    {
        $page = Request::post('page/d', 1); //当前页
        $limit = Request::post('limit/d', 10); //每页数量
        $field = Request::post('field/s', "*"); //寻找字段
        //接收参数post
        $param = array(
            'admin_user_name' => Request::post('admin_user_name/s', ''), //名字
            'admin_user_number' => Request::post('admin_user_number/s', ''), //账号
            'admin_user_phone' => Request::post('admin_user_phone/s', ''), //电话
            'admin_user_email' => Request::post('admin_user_email/s', ''), //邮箱
            'admin_user_status' => Request::post('admin_user_status/s', ''), //状态
            'start_time' => Request::post('startTime/s', ''), //开始时间
            'end_time' => Request::post('entTime/s', '') //结束时间
        );
        $data = AdminUserService::findList($param,$page,$limit,$field);

        return success($data);
    }

    /**
     * 用户添加
     *
     * @method POST
     * 
     * @return json
     */
    public function userAdd()
    {
        //接收参数post
        $param = array(
            'admin_user_name' => Request::post('admin_user_name/s', ''), //名字
            'admin_user_number' => Request::post('admin_user_number/s', ''), //账号
            'admin_user_area_code' => Request::post('admin_user_area_code/d', ''), //区号
            'admin_user_phone' => Request::post('admin_user_phone/d', ''), //电话
            'admin_user_email' => Request::post('admin_user_email/s', null), //邮箱
            'admin_user_pwd' => Request::post('admin_user_pwd/s', ''), //密码
            'admin_role_id' => Request::post('admin_role_id/d', ''), //角色ID
            'admin_user_remark' => Request::post('admin_user_remark/s', '') //备注
        );
        validate(AdminUserValidate::class)->scene('user_add')->check($param);
        $data = AdminUserService::add($param);
        return success($data);
    }

    /**
     * 用户修改
     *
     * @method GET|POST
     * 
     * @return json
     */
    public function userEdit()
    {
        //接收参数post
        $param = array(
            'admin_user_id' => Request::post('admin_user_id/d', ''), //ID
            'admin_user_name' => Request::post('admin_user_name/s', ''), //名字
            'admin_user_area_code' => Request::post('admin_user_area_code/d', ''), //区号
            'admin_user_phone' => Request::post('admin_user_phone/d', ''), //电话
            'admin_user_email' => Request::post('admin_user_email/s', null), //邮箱
            'admin_role_id' => Request::post('admin_role_id/d', ''), //角色ID
            'admin_user_remark' => Request::post('admin_user_remark/s', '') //备注
        );
        validate(AdminUserValidate::class)->scene('user_edit')->check($param);
        $data = AdminUserService::edit($param);
        return success($data);
    }

    /**
     * 用户删除
     *
     * @method POST
     * 
     * @return json
     */
    public function userDel()
    {
        $param['admin_user_id'] = Request::param('admin_user_id/d', '');

        validate(AdminUserValidate::class)->scene('user_dele')->check($param);

        $data = AdminUserService::dele($param['admin_user_id']);

        return success($data);
    }

    /**
     * 用户是否禁用
     *
     * @method POST
     * 
     * @return json
     */
    public function userStatusUpdate()
    {
        $param['admin_user_id'] = Request::param('admin_user_id/d', '');
        $param['admin_user_status'] = Request::param('admin_user_status/d', '');

        validate(AdminUserValidate::class)->scene('user_disable')->check($param);

        $data = AdminUserService::isDisable($param);

        return success($data);
    }

    /**
     * 用户是否管理员
     *
     * @method POST
     * 
     * @return json
     */
    public function userIsAdmin()
    {
        
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        $param['admin_user_is_admin'] = Request::post('admin_user_is_admin/d', '');
        validate(AdminUserValidate::class)->scene('user_admin')->check($param);
        $data = AdminUserService::isAdmin($param);
        return success($data);
    }

    /**
     * 用户分配菜单
     *
     * @method POST
     * 
     * @return json
     */
    public function userMenu()
    {
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        $param['admin_menu_id'] = Request::post('admin_menu_id/s', '');
        $param['admin_menu_checked_id'] = Request::post('admin_menu_checked_id/s', '');
        validate(AdminUserValidate::class)->scene('user_menu')->check($param);
        $data = AdminUserService::userMenu($param);
        return success($data);
    }

    /**
     * 角色分配权限
     *
     * @method POST
     * 
     * @return json
     */
    public function userAuth()
    {
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        $param['admin_auth_id'] = Request::post('admin_auth_id/s', '');
        validate(AdminUserValidate::class)->scene('user_auth')->check($param);
        $data = AdminUserService::userAuth($param);
        return success($data);
    }

    /**
     * 登陆密码重置
     *
     * @method POST
     * 
     * @return json
     */
    public function userNewPwd()
    {
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        validate(AdminUserValidate::class)->scene('user_new_pwd')->check($param);
        $data = AdminUserService::newPwd($param);
        return success($data);
    }
    
    /**
     * 修改用户密码,所有用户的权限白名单
     * @method POST
     * 
     * @return json
     */
    public function userEditPwd(){
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        $param['y_pwd']   = Request::post('y_pwd/s', '');
        $param['new_pwd'] = Request::post('new_pwd/s', '');
        validate(AdminUserValidate::class)->scene('user_edit_pwd')->check($param);
        return AdminUserService::editPwd($param);
    }

}
