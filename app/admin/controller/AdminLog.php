<?php
/*
 * @Description  : 日志管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-06
 * @LastEditTime : 2021-01-04
 */

namespace app\admin\controller;

use think\facade\Request;
use app\admin\service\AdminLogService;

class AdminLog
{
    /**
     * 日志列表
     *
     * @method GET
     * 
     * @return json
     */
    public function logList()
    {
        $page = Request::post('page/d', 1); //当前页
        $limit = Request::post('limit/d', 10); //每页数量
        $field = Request::post('field/s', "*"); //寻找字段
        $param = [
            'admin_user_id'     => Request::post('admin_user_id/d', ''),
            'log_visit_path'    => Request::post('log_visit_path/s', ''),
            'log_type'          => Request::post('log_type/d', ''),
            'request_ip'        => Request::post('request_ip/s', ''),
            'request_method'    => Request::post('request_method/s', ''),
            'create_time_start' => Request::post('create_time_start/s', ''),
            'create_time_end'   => Request::post('create_time_end/s', '')
        ];
        $data = AdminLogService::findList($param, $page, $limit,$field);

        return success($data);
    }
}
