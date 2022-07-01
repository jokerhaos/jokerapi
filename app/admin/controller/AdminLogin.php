<?php
/*
 * @Description  : 登录退出
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-26
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\validate\AdminVerifyValidate;
use app\admin\validate\AdminUserValidate;
use app\admin\service\AdminVerifyService;
use app\admin\service\AdminLoginService;

class AdminLogin
{
    /**
     * 验证码
     *
     * @method GET
     *
     * @return json
     */
    public function verify()
    {
        $AdminVerifyService = new AdminVerifyService();

        $data = $AdminVerifyService->verify();
        return success($data);
    }

    /**
     * 登录
     *
     * @method POST
     * 
     * @return json
     */
    public function login()
    {
        $param['admin_user_number'] = Request::post('username/s', '');
        $param['admin_user_pwd']    = Request::post('password/s', '');
        $param['verify_id']         = Request::post('code_id/s', '');
        $param['verify_code']       = Request::post('code/s', '');
        $param['request_ip']        = Request::ip();
        $param['request_method']    = Request::method();
        $verify_config = AdminVerifyService::config();
        if ($verify_config['switch']) {
            validate(AdminVerifyValidate::class)->scene('check')->check($param);
        }
        validate(AdminUserValidate::class)->scene('user_login')->check($param);
        return AdminLoginService::login($param);
    }

    /**
     * 退出
     *
     * @method POST
     * 
     * @return json
     */
    public function logout()
    {
        $param['admin_user_id'] = Request::post('admin_user_id/d', '');
        validate(AdminUserValidate::class)->scene('user_id')->check($param);
        $redisKey = get_redis_key();
        return AdminLoginService::logout($param['admin_user_id'], $redisKey);
    }
}
