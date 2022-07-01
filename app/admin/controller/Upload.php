<?php
/*
 * @Description  : 上传管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-03-30
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\controller;

use app\admin\validate\UploadValidate;
use think\facade\Config;
use think\facade\Filesystem;
use think\facade\Request;
use think\Image;

class Upload
{

    /**
     * 上传图片
     *
     * @method POST
     * 
     * @return json
     */
    public function images()
    {
        $param = array(
            'images' => Request::file('images')
        );
        validate(UploadValidate::class)->scene('images')->check($param);
        //文件上传处理
        $savename = Filesystem::disk("bizhi")->putFile('bz',Request::file('images'));
        if(!$savename){
            return error('文件上传失败！');
        }
        unset($param['file']);
        $param['set_path'] = str_replace("\\","/",$savename);
        //生成缩略图
        $path = Config::get("filesystem.disks.bizhi.root");
        $filePath = str_replace("\\","/",$path."/".$param['set_path']);
        $fileName = basename($filePath);
        $s_path = str_replace($fileName,"s_".$fileName,$filePath);
        try{
            if(is_file($filePath)){
                $image = Image::open($filePath);
                $image->thumb(160, 266)->save($s_path);
            }
        }catch(\Exception $e){
            if(is_file($filePath)){
                unlink($filePath);
            }
            if(is_file($s_path)){
                unlink($s_path);
            }
            return error($e->getMessage());
        }
        //数据添加
        return success(['s_path'=>ltrim($s_path,"./upload/"),'path'=>ltrim($filePath,"./upload/")],'上传成功');
    }

}
