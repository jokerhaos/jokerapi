<?php
/*
 * @Description  : 登陆信息缓存
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-06-12
 * @LastEditTime : 2020-12-09
 */

namespace app\common\cache;

class AdminLoginCache
{
    /**
     * redis表名
     *
     * @param integer $admin_user_id 用户id
     * 
     * @return string
     */
    public static function key($admin_user_id)
    {
        $key = 'adminLoginInfo:' . $admin_user_id;
        return $key;
    }

    /**
     * 缓存设置
     *
     * @param integer $admin_user_id 用户id
     * @param string  $auth_data     用户权限数据
     * @param string  $token         登陆token
     * @param string  $redisKey      哈希表key
     * @param integer $expire        有效时间（秒） 0 永久
     * 
     * @return bool
     */
    public static function set($admin_user_id, $auth_data, $token, $redisKey, $expire = 86400)
    {
        $t = self::key($admin_user_id);
        $res = RedisHash::Hset($t, $redisKey, [
            'auth' => $auth_data,
            'token' => $token,
            'time' => time(),
            'date' => date('Y-m-d H:i:s')
        ], $expire);
        return $res;
    }

    /**
     * 缓存获取
     *
     * @param integer $admin_user_id 用户id
     * @param string  $key      redis 哈希表key
     * 
     * @return string
     */
    public static function get($admin_user_id, $key)
    {
        $t = self::key($admin_user_id);
        $res = RedisHash::Hget($t, $key);
        return $res;
    }

    /**
     * 缓存删除
     *
     * @param integer $admin_user_id 用户id
     * @param string  $redisKey      redis 哈希表key
     * @param string  $menu_url      菜单url
     * 
     * @return bool
     */
    public static function del($admin_user_id, $redisKey = '')
    {
        $t = self::key($admin_user_id);
        if ($redisKey == '' || $redisKey == null) {
            //全部删除
            RedisHash::HdelTable($t);
        } else {
            RedisHash::Hdel($t, $redisKey);
        }
        return [];
    }
}
