<?php
/*
 * @Description  : 权限验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;

class AdminAuthValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_auth_id'    => ['require'],
        'admin_auth_name'  => ['require'],
        'admin_auth_path' => ['require']
    ];

    // 错误信息
    protected $message = [
        'admin_auth_id.require'    => '缺少参数：权限id',
        'admin_auth_name.require'  => '请输入权限名称',
        'admin_auth_path.require'  => '请输入权限路径',
    ];

    // 验证场景
    protected $scene = [
        'auth_id'          => ['admin_auth_id'],
        'auth_add'         => ['admin_auth_name','admin_auth_path'],
        'auth_edit'        => ['admin_auth_id', 'admin_auth_name','admin_auth_path'],
        'auth_dele'        => ['admin_auth_id'],
    ];
}
