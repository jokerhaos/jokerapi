<?php
/*
 * @Description  : 日志中间件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-06
 * @LastEditTime : 2020-12-24
 */

namespace app\admin\middleware;

use Closure;
use think\Request;
use think\Response;
use think\facade\Config;
use app\admin\service\AdminLogService;
use app\common\lib\Logger;

class AdminLog
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
        $uid = rand(11111, 99999) . time();
        $create_time = date('Y-m-d H:i:s');
        $is_log = Config::get('admin.is_log', false);
        $admin_user_id = admin_user_id();
        $log_visit_path = request_pathinfo();
        //钩子前-记录日志
        Logger::info($uid, '-------------------Logger start-------------------');
        Logger::info($uid, '请求时间：' . $create_time);
        Logger::info($uid, '请求地址：' . $log_visit_path);
        Logger::info($uid, '请求方式：' . $request->method());
        Logger::info($uid, '请求IP：' . $request->ip());
        Logger::info($uid, '请求参数：' . json_encode($request->param(), JSON_UNESCAPED_UNICODE));
        $response = $next($request);
        //钩子后-记录日志
        $responseData = $response->getData();
        if (!is_array($responseData)) {
            $code = '';
            $msg = $responseData;
        } else {
            $code = $responseData['code'];
            $msg = $responseData['msg'] ?? $responseData['message'];
        }
        Logger::info($uid, '返回状态码：' . $code);
        Logger::info($uid, '返回描述：' . $msg);
        Logger::info($uid, '-------------------Logger end-------------------');
        //记录数据库日志
        $requestParam = $request->param();
        if ($log_visit_path == 'admin/AdminLogin/login') {
            if ($code == 200) {
                $admin_user_id = $response->getData()['data']['user']['admin_user_id'];
                $requestParam['password'] = '******';
            }
        } elseif ($log_visit_path == 'admin/AdminUser/userEditPwd') {
            $requestParam['y_pwd'] = '******';
            $requestParam['new_pwd'] = '******';
            $requestParam['new_confirm_pwd'] = '******';
        }
        if ($is_log && !empty($admin_user_id) && $admin_user_id != 'undefined' && $log_visit_path != '' && $log_visit_path != 'admin/AdminLogin/verify') {
            $log_type = 2;
            if ($log_visit_path == 'admin/AdminLogin/login') {
                $log_type = 1;
            } elseif ($log_visit_path == 'admin/AdminLogin/logout') {
                $log_type = 3;
            }
            $param = [
                'admin_user_id'  => $admin_user_id,
                'log_visit_path' => $log_visit_path,
                'log_type'       => $log_type,
                'request_ip'     => $request->ip(),
                'request_method' => $request->method(),
                'request_param'  => json_encode($requestParam, JSON_UNESCAPED_UNICODE),
                'create_time'    => $create_time,
                'update_time'    => date('Y-m-d H:i:s'),
                'response_code'  => $code,
                'response_msg'   => $msg
            ];
            AdminLogService::add($param);
        }
        return $response;
    }
}
