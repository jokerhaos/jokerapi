<?php
/*
 * @Description  : 菜单验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;
use think\facade\Db;

class AdminMenuValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_menu_id'    => ['require'],
        'admin_menu_name'  => ['require', 'checkAdminMenu'],
        'admin_menu_title' => ['require'],
        'admin_menu_icon'  => ['require'],
        'admin_menu_path'  => ['require'],
        'admin_menu_sort'  => ['require'],
        'admin_menu_pid'   => ['require'],
        'ids'              => ['require'],
    ];

    // 错误信息
    protected $message = [
        'admin_menu_id.require'    => '缺少参数：菜单id',
        'admin_menu_name.require'  => '请输入菜单名称',
        'admin_menu_title.require' => '请输入菜单标题',
        'admin_menu_icon.require'  => '请输入菜单图标',
        'admin_menu_path.require'  => '请输入菜单路径',
        'admin_menu_sort.require'  => '请输入菜单排序',
        'admin_menu_pid.require'   => '请输入父级菜单',
        'ids.require'              => 'id集合不能为空'
    ];

    // 验证场景
    protected $scene = [
        'menu_id'          => ['admin_menu_id'],
        'menu_add'         => ['admin_menu_name','admin_menu_title','admin_menu_icon','admin_menu_path','admin_menu_sort'],
        'menu_edit'        => ['admin_menu_id', 'admin_menu_name','admin_menu_title','admin_menu_icon','admin_menu_path','admin_menu_sort'],
        'menu_dele'        => ['ids'],
    ];


    // 自定义验证规则：菜单是否已存在
    protected function checkAdminMenu($value, $rule, $data = [])
    {
        $admin_menu_id = isset($data['admin_menu_id']) ? $data['admin_menu_id'] : '';
        $menu_name = Db::name('admin_menu')
            ->field('admin_menu_id')
            ->where('admin_menu_id', '<>', $admin_menu_id)
            ->where('admin_menu_name', $data['admin_menu_name'])
            ->find();
        if ($menu_name) return '菜单名称已存在：' . $data['admin_menu_name'];
        return true;
    }
}
