<?php
/*
 * @Description  : admin配置
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-20
 */

return [
    // 系统管理员id
    'admin_ids' => [1],
    // 是否记录日志
    'is_log' => env('admin.is_log', false),
    // token密钥
    'token_key' => env('admin.token_key', '3fPbaNsdIFkqaxx5'),
    // 请求头部token键名
    'admin_token_key' => 'Authorization',
    // 请求头部user_id键名
    'admin_user_id_key' => 'BzAdminuserId',
    // 请求头部redis_key键名
    'admin_redis_key' => 'BzRedisKey',
    //登陆过期时间
    'admin_login_expire' => 180000,
    // 接口白名单
    'api_white_list' => env('app.api_white_list', [
        'admin/AdminLogin/verify',
        'admin/AdminLogin/login'
    ]),
    // 权限白名单
    'rule_white_list' => env('app.rule_white_list', [
        'admin/AdminUser/userEditPwd',
        'admin/AdminLogin/logout',
        'admin/Upload/images',
    ]),
    // token 
    'token' => [
        // 密钥
        'key' => env('admin.token_key', '3fPbaNsdIFkqaxx5'),
        // 签发者
        'iss' => 'newgm',
        // 有效时间(小时)
        'exp' => 24,
    ],
    // 请求频率限制（次数/时间）
    'throttle' => [
        'number' => 100, //次数,0不限制
        'expire' => 1, //时间,单位秒
    ],
];
