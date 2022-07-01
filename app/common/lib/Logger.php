<?php

namespace app\common\lib;

use think\facade\Request;
use Exception;
use think\facade\Env;

class Logger
{
    static private $action;
    static private $controller;

    static private function mkdir()
    {
        $module = app('http')->getName();; //模块
        $controller = app('request')->controller(); //控制器
        $action = app('request')->action(); //方法
        self::$action = $action;
        self::$controller = $controller;
        $path = root_path() . 'runtime/log/';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $path .= $module;
        //判断文件是否存在
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }

    static public function info($uid = '', $str = '')
    {
        try {
            $path = self::mkdir();
            if ($path == '') throw new Exception("路径为空！！！");
            if ($str == '') throw new Exception("内容为空！！！");
            $info = "[INFO] " . date("Y-m-d H:i:s") . " [$uid]" . '[' . Env::get('wx3_app.id') . '_' . Env::get('wx3_app.corp_name') . ']' . "[" . self::$controller . "][" . self::$action . "]" . ":" . $str;
            file_put_contents($path . "/" . date("Y-m-d") . ".log", $info . "\r\n", FILE_APPEND);
        } catch (\Exception $e) {
            $str = '报错文件：' . $e->getFile() . '-报错行数：' . $e->getLine() . '-报错描述：' . $e->getMessage();
            $p = root_path() . 'runtime/log/error_' . date('Y-m-d') . ".log";
            @file_put_contents($p, $str);
            // return request_error("系统异常：" . $e->getMessage());
        }
    }

    static public function error($uid = '', $str = '')
    {
        try {
            $path = self::mkdir();
            if ($path == '') throw new Exception("路径为空！！！");
            if ($str == '') throw new Exception("内容为空！！！");
            $info = "[ERROR] " . date("Y-m-d H:i:s") . " [$uid]" . '[' . Env::get('wx3_app.id') . '_' . Env::get('wx3_app.corp_name') . ']' . "[" . self::$controller . "][" . self::$action . "]" . ":" . $str;
            file_put_contents($path . "/" . date("Y-m-d") . ".log", $info . "\r\n", FILE_APPEND);
        } catch (\Exception $e) {
            $str = '报错文件：' . $e->getFile() . '-报错行数：' . $e->getLine() . '-报错描述：' . $e->getMessage();
            $p = rtrim(str_replace('\\', '/', Env::get('root_path')), '/') . '/runtime/log/error_' . date('Y-m-d') . ".log";
            @file_put_contents($p, $str);
            // return request_error("系统异常：" . $e->getMessage());
        }
    }
}
