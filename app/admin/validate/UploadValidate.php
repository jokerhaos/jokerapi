<?php
/*
 * @Description  : 文件上传验证器
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\validate;

use think\Validate;

class UploadValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'images' => ['require','fileSize'=>10485760,'fileExt'=>'jpg,JPG,jpeg,JPEG,png,PNG,gif.GIF']
    ];

    // 错误信息
    protected $message = [
        'images.fileSize' => '图片最大10M！',

    ];

    // 验证场景
    protected $scene = [
        'images' => ['images'],
    ];
}
