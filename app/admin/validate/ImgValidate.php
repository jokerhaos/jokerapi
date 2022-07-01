<?php
/*
 * @Description  : 壁纸图片验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;

class ImgValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'img_id'       => ['require'],
        'category_ids' => ['require'],
        'name'         => ['require'],
        'title'        => ['require'],
        'sort'         => ['require'],
        'source_name'  => ['require'],
        'source_path'  => ['require'],
        'status'       => ['require'],
        'set_path'     => ['require'],
    ];

    // 错误信息
    protected $message = [
        'img_id.require'       => '缺少参数：壁纸图片id',
        'category_ids.require' => '请输入类别ID集合',
        'name.require'         => '请输入图片名字',
        'title.require'        => '请输入图片标题',
        'sort.require'         => '请输入图片排序',
        'source_name.require'  => '请输入来源名字',
        'source_path.require'  => '请输入来源路径',
        'status.require'       => '请输入状态字段',
        'set_path.require'     => '请先上传图片',

    ];

    // 验证场景
    protected $scene = [
        'img_add'     => ['category_ids','name','title','sort','source_name','source_path','set_path'],
        'img_edit'    => ['category_ids','img_id','name','title','sort','source_name','source_path'],
        'cateGory_dele'    => ['category_id','category_type'],
        'cateGory_status_update' => ['category_id','category_type']
    ];
}
