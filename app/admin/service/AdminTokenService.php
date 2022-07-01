<?php
/*
 * @Description  : Token
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use app\common\cache\AdminLoginCache;
use think\facade\Config;
use Exception;
use Firebase\JWT\JWT;

class AdminTokenService
{
    /**
     * Token生成
     * 
     * @param array $tokenData 用户数据
     * 
     * @return string
     */
    public static function create($tokenData)
    {
        $admin_token = Config::get('admin.token');
        $key         = $admin_token['key'];                  //密钥
        $iss         = $admin_token['iss'];                  //签发者
        $iat         = time();                               //签发时间
        $nbf         = time();                               //生效时间
        $exp         = time() + $admin_token['exp'] * 3600;  //过期时间
        $payload = [
            'iss'  => $iss,
            'iat'  => $iat,
            'nbf'  => $nbf,
            'exp'  => $exp,
            'data' => $tokenData,
        ];
        $token = JWT::encode($payload, $key);
        return $token;
    }

    /**
     * Token验证
     *
     * @param string  $token         token
     * @param integer $admin_user_id 用户id
     * @param integer $redis_key redis键名
     * 
     * @return json
     */
    public static function verify($token)
    {
        try {
            //token校验
            $key    = Config::get('admin.token.key');
            $decode = JWT::decode($token, $key, array('HS256'));
            if (empty($decode)) throw new Exception("Token解析为空");
            $admin_user_id_token = $decode->data->admin_user_id;
            $redis_key_token = $decode->data->redis_key;
            // if ($admin_user_id != $admin_user_id_token) throw new Exception('账号请求信息错误', 401);
            // if ($redis_key_token != $redis_key) throw new Exception("redis_key信息不正确");
            //redis信息二次校验
            $loginInfo = AdminLoginCache::get($admin_user_id_token, $redis_key_token);
            if (!$loginInfo || $loginInfo == '') throw new Exception('用户token过期！', 401);
            $loginInfo = json_decode($loginInfo, true);
            if (time() - $loginInfo['time'] > Config::get('admin.admin_login_expire')) throw new Exception("登陆时间过期！");
            if (env('app.SIGNLE_LOGIN', false)) if ($loginInfo['token'] != $token) throw new Exception('用户已经在别处登陆', 401);
            return $loginInfo;
        } catch (\Exception $e) {
            exception($e->getMessage(), 401);
        }
    }
}
