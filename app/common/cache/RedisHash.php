<?php
/*
 * @Description  : 自定义redis hash表操作
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-07-09
 * @LastEditTime : 2020-12-03
 */

namespace app\common\cache;
use think\facade\Cache;
use think\facade\Config;

class RedisHash
{

    private static function prefix()
    {
        return Config::get("cache.redis.prefix");
    }

    /**
     * redisInit操作
     */
    private static function redisInit()
    {
        return Cache::store('redis')->handler();
    }

    /**
     * 将哈希表 key 中的字段 field 的值设为 value 。
     * @param   string  $key 表名
     * @param   string  $hashKey 字段名
     * @param   string  $value 存储值
     * @param   integer  $expire 过期时间 单位 s
     * 
     * @return bool
     */
    public static function Hset($key, $hashKey, $value ,$expire = null)
    {
        if ($expire === null) {
            $expire = Config::get('cache.redis.expire');
        }
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key,JSON_UNESCAPED_UNICODE) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey,JSON_UNESCAPED_UNICODE) : $hashKey;
        $value  =  (is_object($value) || is_array($value)) ? json_encode($value,JSON_UNESCAPED_UNICODE) : $value;
        $result = self::redisInit()->hSet(self::prefix().$key, $hashKey, $value );
        if(is_int($expire) && $expire){
            self::redisInit()->expire(self::prefix().$key,$expire);
        }
        return $result;
    }

    /**
     * 获取存储在哈希表中指定字段的值
     * @param   string  $key 表名
     * @param   string  $hashKey 字段名
     * 
     * @return bool
     */
    public static function Hget($key,$hashKey)
    {
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $result = self::redisInit()->hGet(self::prefix().$key,$hashKey);
        return $result;
    }

    /**
     * 删除存储在哈希表中指定字段的值
     * @param   string  $key 表名
     * @param   string  $hashKey 字段名
     * 
     * @return bool
     */
    public static function Hdel($key,$hashKey)
    {
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $result = self::redisInit()->hDel(self::prefix().$key,$hashKey);
        return $result;
    }

    /**
     * 删除整个哈希表
     * @param   string  $key 表名
     * 
     * @return bool
     */
    public static function HdelTable($key)
    {
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result = self::redisInit()->del(self::prefix().$key);
        return $result;
    }

    /**
     * 判断hash表中是否存在指定的key
     * @param string $key 表名
     * @param string $hasKey 字段名
     * 
     * @return bool
     */
    public static function Hexists($key,$hasKey)
    {
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result = self::redisInit()->hExists(self::prefix().$key,$hasKey);
        return $result;
    }


    /**
     * 将哈希表 批量插入
     * @param   string  $key 表名
     * @param   array  $data 存储数据
     * @param   integer  $expire 过期时间 单位 s
     * 
     * @return bool
     */
    public static function Hmset($key, $data,$expire = 0)
    {
        if ($expire === null) {
            $expire = Config::get('cache.redis.expire');
        }
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key,JSON_UNESCAPED_UNICODE) : $key;
        $result = self::redisInit()->hMset(self::prefix().$key, $data);
        if(is_int($expire) && $expire){
            self::redisInit()->expire(self::prefix().$key,$expire);
        }
        return $result;
    }
}