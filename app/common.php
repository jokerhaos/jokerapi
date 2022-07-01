<?php
/*
 * @Description  : 公共文件
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-04-16
 * @LastEditTime: 2021-08-25 13:50:53
 */

use app\common\lib\Logger;
use think\facade\Request;

/**
 * 计算指定日期和现在距离几周
 */
function gap_week($time)
{
    //获取本周一时间戳
    $currentMonday = strtotime(date('Y-m-d')) - ((date('w') ?: 7) - 1) * 24 * 3600;
    //获取目标周周一时间戳
    $targetMonday = strtotime(date('Y-m-d', $time)) - ((date('w', $time) ?: 7) - 1) * 24 * 3600;
    //得出差额 然后除一周的时间戳
    return ($currentMonday - $targetMonday) / (7 * 24 * 3600);
}

/**
 *   获取当天是本月的第几周
 */
function get_weeks($time)
{
    #  本月第一天
    $oneDay = date('Y-m-01', $time);
    #  本月天数
    $tolDay = date('d', strtotime("$oneDay +1 month -1 day"));
    #  获取今天的日期
    $day = date('d', $time);
    #  计算本月第一天是周几
    $week = date('w', strtotime($oneDay));
    #  获取本月第一周有多少天
    $arr = [1, 7, 6, 5, 4, 3, 2];
    $weekDay = $arr[$week];
    if ($day <= $weekDay)
        return 1;
    #  本月除去第一周剩余的天数
    $days = $tolDay - $weekDay;
    #  本月除了第一周还剩余多少周
    $d = ceil($days / 7);
    #  本月第二周的第一天
    $w = $weekDay + 1;
    $d = 2;
    $i = 0;
    for ($w; $w <= $tolDay; $w++) {
        $i++;
        if ($i == 8) {
            $i = '1';
            $d++;
        }
        if ($day == $w) {
            return $d;
        }
    }
}

/**
 * 随机生成字符串
 *
 * @param integer  $length 生成长度
 * 
 * @return string
 */
function randomkeys($length)
{
    $key = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern[mt_rand(0, 35)];    //生成php随机数   
    }
    return $key;
}

/**
 * 成功返回
 *
 * @param array   $data 成功数据
 * @param string  $msg  成功提示
 * @param integer $code 成功码
 * 
 * @return json
 */
function success($data = [], $msg = '操作成功', $code = 200)
{
    return json([
        'code' => $code,
        'msg'  => $msg,
        'data' => $data
    ]);
}

/**
 * 错误返回
 *
 * @param string  $msg  错误提示
 * @param array   $err  错误数据
 * @param integer $code 错误码
 * 
 * @return json
 */
function error($msg = '操作失败', $err = [], $code = 400)
{
    return json([
        'code' => $code,
        'msg'  => $msg,
        'err'  => $err
    ]);
}

/**
 * 抛出异常
 *
 * @param string  $msg  异常提示
 * @param integer $code 错误码
 * 
 * @return json
 */
function exception($msg = '操作失败', $code = 400)
{
    // throw new \think\Exception($msg, $code);
    throw new \think\exception\HttpException($code, $msg);
}

/**
 * 服务器地址
 * 协议和域名
 *
 * @return string
 */
function server_url()
{
    if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
        $http = 'https://';
    } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
        $http = 'https://';
    } else {
        $http = 'http://';
    }

    $host = $_SERVER['HTTP_HOST'];
    $res  = $http . $host;

    return $res;
}

/**
 * 文件地址
 * 协议，域名，文件路径
 *
 * @param string $file_path 文件路径
 * 
 * @return string
 */
function file_url($file_path = '')
{
    if (empty($file_path)) {
        return '';
    }

    if (strpos($file_path, 'http') !== false) {
        return $file_path;
    }

    $server_url = server_url();

    if (stripos($file_path, '/') === 0) {
        $res = $server_url . $file_path;
    } else {
        $res = $server_url . '/' . $file_path;
    }

    return $res;
}

/**
 * 获取请求pathinfo
 * 应用/控制器/操作 
 * eg：admin/Index/index
 *
 * @return string
 */
function request_pathinfo()
{
    $request_pathinfo = app('http')->getName() . '/' . Request::pathinfo();

    return $request_pathinfo;
}

/**
 * http get 请求
 *
 * @param string $url    请求地址
 * @param array  $header 请求头部
 *
 * @return array
 */
function http_get($url, $header = [])
{
    if (empty($header)) {
        $header = [
            "Content-type:application/json;",
            "Accept:application/json"
        ];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);

    return $response;
}

/**
 * http post 请求
 *
 * @param string $url    请求地址
 * @param array  $param  请求参数
 * @param array  $header 请求头部
 *
 * @return array
 */
function http_post($url, $param = [], $header = [])
{
    $param  = json_encode($param);

    if (empty($param)) {
        $header = [
            "Content-type:application/json;charset='utf-8'",
            "Accept:application/json"
        ];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);

    return $response;
}
