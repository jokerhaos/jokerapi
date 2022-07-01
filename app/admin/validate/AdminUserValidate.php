<?php
/*
 * @Description  : 用户验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;
use think\facade\Db;

class AdminUserValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_user_id'         => ['require'],
        'admin_user_number'     => ['require', 'checkUserNumber', 'length' => '2,32'],
        'admin_user_name'       => ['require', 'length' => '1,32'],
        'admin_user_area_code'  => ['require'],
        'admin_user_phone'      => ['require','checkPhone'],
        'admin_user_email'      => ['email', 'checkEmail'],
        'admin_user_pwd'        => ['require', 'length' => '6,18'],
        'admin_role_id'         => ['require'],
        'admin_user_is_admin'   => ['require'],
        'admin_user_status'     => ['require'],
        'admin_menu_id'         => ['require'],
        'admin_menu_checked_id' => ['require'],
        'admin_auth_id'         => ['require'],
        'y_pwd'                 => ['require', 'length' => '6,18'],
        'new_pwd'               => ['require', 'length' => '6,18']
    ];

    // 错误信息
    protected $message = [
        'admin_user_id.require'         => '缺少参数：用户id',
        'admin_user_number.require'     => '请输入账号',
        'admin_user_number.length'      => '账号长度为2至32个字符',
        'admin_user_name.require'       => '请输入昵称',
        'admin_user_name.length'        => '昵称长度为1至32个字符',
        'admin_user_area_code.require'  => '请输入手机区号',
        'admin_user_phone.require'      => '请输入手机号码',
        'admin_user_email.email'        => '请输入正确的邮箱地址',
        'admin_user_pwd.require'        => '请输入密码',
        'admin_user_pwd.length'         => '密码长度为6至18个字符',
        'admin_role_id.require'         => '请输入角色ID',
        'admin_user_is_admin.require'   => '缺少参数：超管状态字段',
        'admin_user_status.require'     => '缺少参数：用户状态字段',
        'y_pwd.require'                 => '缺少参数：旧密码',
        'y_pwd.length'                  => '密码长度为6至18个字符',
        'new_pwd.require'               => '缺少参数：新密码',
        'new_pwd.length'                => '密码长度为6至18个字符',
    ];

    // 验证场景
    protected $scene = [
        'user_id'       => ['admin_user_id'],
        'user_login'    => ['admin_user_number', 'admin_user_pwd'],
        'user_add'      => ['admin_user_number', 'admin_user_name', 'admin_user_area_code', 'admin_user_phone','admin_user_email','admin_user_pwd','admin_role_id'],
        'user_edit'     => ['admin_user_id', 'admin_user_name', 'admin_user_area_code', 'admin_user_phone','admin_user_email','admin_role_id'],
        'user_dele'     => ['admin_user_id'],
        'user_admin'    => ['admin_user_id','admin_user_is_admin'],
        'user_disable'  => ['admin_user_id','admin_user_status'],
        'user_menu'     => ['admin_user_id'],
        'user_auth'     => ['admin_user_id'],
        'user_new_pwd'  => ['admin_user_id'],
        'user_edit_pwd' => ['admin_user_id','y_pwd','new_pwd']
    ];

    // 验证场景定义：登录
    protected function sceneuser_login()
    {
        return $this->only(['admin_user_number', 'admin_user_pwd'])
            ->remove('admin_user_number', ['length', 'checkUserNumber']);
    }


    // 自定义验证规则：账号是否已存在
    protected function checkUserNumber($value, $rule, $data = [])
    {
        $admin_user_id = isset($data['admin_user_id']) ? $data['admin_user_id'] : '';
        $admin_user_number      = $data['admin_user_number'];
        if ($admin_user_id) {
            $where[] = ['admin_user_id', '<>', $admin_user_id];
        }
        $where[] = ['admin_user_number', '=', $admin_user_number];
        $admin_user = Db::name('admin_user')->field('admin_user_id')->where($where)->find();
        if ($admin_user)  return '账号已存在：' . $admin_user_number;
        return true;
    }

    // 自定义验证规则：邮箱是否已存在
    protected function checkEmail($value, $rule, $data = [])
    {
        $admin_user_id = isset($data['admin_user_id']) ? $data['admin_user_id'] : '';
        $admin_user_email = $data['admin_user_email'];
        if ($admin_user_id) {
            $where[] = ['admin_user_id', '<>', $admin_user_id];
        }
        $where[] = ['admin_user_email', '=', $admin_user_email];
        $admin_user = Db::name('admin_user')->field('admin_user_id')->where($where)->find();
        if ($admin_user)  return '邮箱已存在：' . $admin_user_email;
        return true;
    }

    //自定义验证：手机号是否存在
    protected function checkPhone($value, $rule, $data = [])
    {
        $admin_user_id = isset($data['admin_user_id']) ? $data['admin_user_id'] : '';
        $admin_user_phone = $data['admin_user_phone'];
        if ($admin_user_id) {
            $where[] = ['admin_user_id', '<>', $admin_user_id];
        }
        $where[] = ['admin_user_phone', '=', $admin_user_phone];
        $admin_user = Db::name('admin_user')->field('admin_user_id')->where($where)->find();
        if ($admin_user)  return '手机号已存在：' . $admin_user_phone;
        return true;
    }
}
