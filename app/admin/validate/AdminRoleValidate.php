<?php
/*
 * @Description  : 角色验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;
use think\facade\Db;

class AdminRoleValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_role_id'   => ['require'],
        'admin_role_code' => ['require', 'checkAdminRule'],
        'admin_role_name' => ['require'],
    ];

    // 错误信息
    protected $message = [
        'admin_role_id.require'   => '缺少参数：角色id',
        'admin_role_code.require' => '请输入角色代码',
        'admin_role_name.require' => '请输入角色名称',
    ];

    // 验证场景
    protected $scene = [
        'role_id'   => ['admin_role_id'],
        'role_add'  => ['admin_role_code','admin_role_name'],
        'role_edit' => ['admin_role_id', 'admin_role_name'],
        'role_dele' => ['admin_role_id'],
        'role_menu' => ['admin_role_id'],
        'role_auth' => ['admin_role_id'],
    ];

    // 自定义验证规则：角色是否已存在
    protected function checkAdminRule($value, $rule, $data = [])
    {
        $admin_role_id = isset($data['admin_role_id']) ? $data['admin_role_id'] : '';
        if ($admin_role_id) {
            $where[] = ['admin_role_id', '<>', $admin_role_id];
        }
        $where[] = ['admin_role_code', '=', $data['admin_role_code']];
        $admin_role = Db::name('admin_role')
            ->field('admin_role_id')
            ->where($where)
            ->find();

        if ($admin_role) {
            return '角色代码已存在：' . $data['admin_role_code'];
        }
        return true;
    }

}
