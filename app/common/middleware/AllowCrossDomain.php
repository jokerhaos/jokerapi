<?php
/*
 * @Description  : 跨域请求中间件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-11-17
 * @LastEditTime : 2020-12-25
 */

namespace app\common\middleware;

use Closure;
use think\facade\Config;
use think\Request;
use think\Response;

class AllowCrossDomain
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
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin,BzAdminuserId,BzAdminToken,Authorization'); // 设置允许自定义请求头的字段
        // Access-Control-Allow-Headers
        //跨域白名单
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allowOrigin = env('app.domain_white_list');
        if (in_array('*', $allowOrigin)) {
            header("Access-Control-Allow-Origin:*");
        } elseif (in_array($origin, $allowOrigin)) {
            header("Access-Control-Allow-Origin:" . $origin);
        }

        if ($request->isOptions()) {
            return Response::create();
        }

        return $next($request);
    }
}
