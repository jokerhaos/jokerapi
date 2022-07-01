<?php
/*
 * @Description  : 类别缓存
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-07-09
 * @LastEditTime : 2020-12-03
 */

namespace app\common\cache;

use think\facade\Db;
use app\common\cache\RedisHash;

class RedisPublic
{
    private $redisTable = ''; //redis 表名
    private $sqlTable = ''; //数据库表名
    private $sqlPrefix = ''; //数据库表名前缀

    /**
     * 设置redis表名
     * 
     * @param string $t 表名
     * 
     * @return object
     */
    public static function setRedisTable($t)
    {
        $RedisPublic = new static;
        $RedisPublic->redisTable = $t;
        return $RedisPublic;
    }

    /**
     * 设置数据库表名
     * 
     * @param string $t 表名
     * 
     * @return object
     * 
     */
    public function setSqlTable($t)
    {
        $this->sqlTable = $t;
        return $this;
    }

    /**
     * 设置数据库表前缀
     * 
     * @param string $p 前缀
     * 
     * @return object
     */
    public function setSqlPrefix($p)
    {
        $this->sqlPrefix = $p;
        return $this;
    }

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
    public function set($id = '',$data = '', $expire = 0,$is_rewrite=false)
    {
        $key = self::key($id);
        $newData = [];
        if($is_rewrite){
            $newData = Db::name($this->sqlTable)->where($this->sqlPrefix."id",$id)->find();
        }else{
            $newData = $data;
        }
        $res = RedisHash::Hset($this->redisTable,$key,$newData, $expire);
        return $res;
    }

    /**
     * 缓存获取
     *
     * @param string $id 缓存ID
     * 
     * @return string
     */
    public function get($id = '')
    {
        $key = self::key($id);
        $res = RedisHash::Hget($this->redisTable,$key);
        return $res;
    }

    /**
     * 缓存删除
     *
     * @param string $id 缓存ID
     * 
     * @return bool
     */
    public function del($id = '')
    {
        $key = self::key($id);
        $res = RedisHash::Hdel($this->redisTable,$key);
        return $res;
    }

    /**
     * 判断hash表中是否存在指定的key
     *
     * @param string $id 缓存字段
     * 
     * @return bool
     */
    public function exists($id = '')
    {
        $key = self::key($id);
        $res = RedisHash::Hexists($this->redisTable,$key);
        return $res;
    }

    /**
     * 缓存设置
     *
     * @param array  $data 缓存数据
     * @param integer $expire 有效时间（秒）
     * @param bool $is_rewrite 是否需要读取数据库重新
     * @param string|array $where 是否需要读取数据库重新
     * 
     * @return bool
     */
    public function mset($data = '', $expire = 0,$is_rewrite=false,$where='')
    {
        $newData = [];
        if($is_rewrite){
            $newData = Db::name($this->sqlTable)->where($where)->column("*",$this->sqlPrefix."id");
        }else{
            $newData = $data;
        }
        $res = RedisHash::Hmset($this->redisTable,$newData, $expire);
        return $res;
    }
}
