<?php
/*
 * @Description  : 类别缓存
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-07-09
 * @LastEditTime : 2020-12-03
 */

namespace app\common\cache;

use think\facade\Db;

class ImgCache
{
    const T = 'img'; //redis 表名
    const MT = 'img'; //数据库表名
    const MT_PREFIX = 'img_'; //数据库表名前缀

    /**
     * 缓存key
     *
     * @param string $id 数据库id
     * 
     * @return string
     */
    public static function key($id = '')
    {
        return $id;
    }

    /**
     * 缓存设置
     *
     * @param string  $id   缓存ID
     * @param string  $data 缓存数据
     * @param integer $expire 有效时间（秒）
     * @param bool $is_rewrite 是否需要读取数据库重新
     * 
     * @return bool
     */
    public static function set($id = '',$data = '', $expire = 0,$is_rewrite=false)
    {
        $key = self::key($id);
        $newData = [];
        if($is_rewrite){
            $newData = Db::name(self::MT)->where(self::MT_PREFIX."id",$id)->find();
        }else{
            $newData = $data;
        }
        $res = RedisHash::Hset(self::T,$key,$newData, $expire);
        return $res;
    }

    /**
     * 缓存获取
     *
     * @param string $id 缓存ID
     * 
     * @return string
     */
    public static function get($id = '')
    {
        $key = self::key($id);
        $res = RedisHash::Hget(self::T,$key);
        return $res;
    }

    /**
     * 缓存删除
     *
     * @param string $id 缓存ID
     * 
     * @return bool
     */
    public static function del($id = '')
    {
        $key = self::key($id);
        $res = RedisHash::Hdel(self::T,$key);
        return $res;
    }
}
