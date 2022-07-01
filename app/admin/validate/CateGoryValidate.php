<?php
/*
 * @Description  : 类别验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;

class CateGoryValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'category_id'     => ['require'],
        'category_name'   => ['require'],
        'category_type'   => ['require'],
        'category_sort'   => ['require'],
        'category_status' => ['require']
    ];

    // 错误信息
    protected $message = [
        'category_id.require'     => '缺少参数：类别id',
        'category_name.require'   => '请输入类别名称',
        'category_type.require'   => '请输入类别类型',
        'category_sort.require'   => '请输入类别排序',
        'category_status.require' => '请输入类别状态'
    ];

    // 验证场景
    protected $scene = [
        'cateGory_add'     => ['category_name','category_type','category_sort'],
        'cateGory_edit'    => ['category_id','category_name','category_type','category_sort'],
        'cateGory_dele'    => ['category_id','category_type'],
        'cateGory_status_update' => ['category_id','category_type']
    ];
}
