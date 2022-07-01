<?php
/*
 * @Description  : 应用中间件定义文件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-10-12
 * @LastEditTime : 2020-11-19
 */

return [
    // token验证
    \app\admin\middleware\AdminTokenVerify::class,
    // 权限验证
    \app\admin\middleware\AdminRuleVerify::class,
    // 请求频率限制
    \app\admin\middleware\AdminThrottle::class,
    // 日志记录
    \app\admin\middleware\AdminLog::class,
];
