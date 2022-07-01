<?php
/*
 * @Description  : 日志管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-06
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use think\facade\Db;

class AdminLogService
{
    const TABLE = "admin_log";

    /**
     * 查询条件
     *
     * @param array   $data   参数
     * 
     * @return array 
     */
    private static function map(array $data){
        $map = [];
        if($data['admin_user_id']){
            $map[] = ['admin_user_id','=',"{$data['admin_user_id']}"];
        }
        if($data['log_visit_path']){
            $map[] = ["log_visit_path",'=',"{$data['log_visit_path']}"];
        }
        if($data['log_type']){
            $map[] = ["log_type",'=',"{$data['log_type']}"];
        }
        if($data['request_ip']){
            $map[] = ["request_ip",'=',"{$data['request_ip']}"];
        }
        if($data['request_method']){
            $map[] = ["request_method",'=',"{$data['request_method']}"];
        }
        if($data['create_time_start'] && $data['create_time_end']){
            $map[] = [
                'create_time','>=',"{$data['create_time_start']}"
            ];
            $map[] = [
                'create_time','<=',"{$data['create_time_end']}"
            ];
        }
        return $map;
    }

    /**
     * 日志列表
     *
     * @param array   $param   参数
     * @param integer $page    页数
     * @param integer $limit   数量
     * @param string  $field   字段
     * 
     * @return array 
     */
    public static function findList($param, $pp = 1, $num = 10,  $field = '*')
    {
        //查询条件
        $map = self::map($param);
        $count = Db::name(self::TABLE)->where($map)->count();
        //计算pp
        $pp = ceil($count / $num) < $pp ? ceil($count / $num) : $pp;
        //查询数据
        $list = Db::name(self::TABLE)->where($map)->order("admin_log_id desc")->page($pp,$num)->field($field)->select();
        return [
            'list' => $list,
            'count' => $count,
            'pp' => $pp
        ];
    }

    /**
     * 日志添加
     *
     * @param array $param 日志数据
     * 
     * @return void
     */
    public static function add($param = [])
    {
        Db::name('admin_log')->strict(false)->insert($param);
    }
}
