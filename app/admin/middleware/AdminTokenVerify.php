<?php
/*
 * @Description  : Token验证中间件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-24
 */

namespace app\admin\middleware;

use Closure;
use think\Request;
use think\Response;
use think\facade\Config;
use app\admin\service\AdminTokenService;

class AdminTokenVerify
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        $menu_url       = request_pathinfo();
        $api_white_list = Config::get('admin.api_white_list');
        if (!in_array($menu_url, $api_white_list)) {
            $admin_token = admin_token();
            if (empty($admin_token)) {
                exception('缺少请求头：admin_token参数');
            }
            // $admin_user_id = admin_user_id();
            // if (empty($admin_user_id)) {
            //     exception('缺少请求头：admin_user_id参数');
            // }
            // $redis_key = get_redis_key();
            // if (empty($redis_key)) {
            //     exception('缺少请求头：用户redis_key参数');
            // }
            $data = AdminTokenService::verify($admin_token);
            $request->admin_user_role = $data;
        }
        return $next($request);
    }
}
