<?php
/*
 * @Description  : 权限验证中间件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-24
 */

namespace app\admin\middleware;

use app\common\cache\AdminLoginCache;
use Closure;
use Exception;
use think\Request;
use think\Response;
use think\facade\Config;

class AdminRuleVerify
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
        try {
            $menu_url        = request_pathinfo();
            $api_white_list  = Config::get('admin.api_white_list');
            $rule_white_list = Config::get('admin.rule_white_list');
            $white_list      = array_merge($rule_white_list, $api_white_list);
            if (!in_array($menu_url, $white_list)) {
                // $admin_user_id = admin_user_id();
                // $admin_redis_key = get_redis_key();
                // dump($request->admin_user_role);
                // dump($admin_redis_key);exit;
                // $loginInfo = AdminLoginCache::get($admin_user_id,$admin_redis_key);
                // $loginInfo = json_decode($loginInfo,true);
                $loginInfo = $request->admin_user_role ?? [];
                $authArr = $loginInfo['auth']['authArr'];
                if (!in_array($menu_url, $authArr)) throw new Exception("权限不足，请联系管理员");
            }
            return $next($request);
        } catch (\Exception $e) {
            exception($e->getMessage(), 403);
        }
    }
}
