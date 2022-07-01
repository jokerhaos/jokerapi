<?php
/*
 * @Description  : 权限管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use think\facade\Db;

class AdminAuthService
{
    const TABLE = "admin_auth";

    /**
     * 查询条件
     *
     * @param array   $data   参数
     * 
     * @return array 
     */
    private static function map(array $data)
    {
        $map = [];
        if ($data['admin_auth_name']) {
            $map[] = ['admin_auth_name', '=', "{$data['admin_auth_name']}"];
        }
        //路径使用模糊查询
        if ($data['admin_auth_path']) {
            $map[] = ["admin_auth_path", 'like', "%{$data['admin_auth_path']}%"];
        }
        return $map;
    }

    /**
     * 权限列表
     *
     * @param array   $param   参数
     * @param integer $page    页数
     * @param integer $limit   数量
     * @param string  $field   字段
     * 
     * @return array 
     */
    public static function findList($param, $pp, $num,  $field, $getAll)
    {
        if ($getAll) {
            return [
                'list' => Db::name(self::TABLE)->order("admin_auth_id desc")->field($field)->select()
            ];
        }
        //查询条件
        $map = self::map($param);
        $count = Db::name(self::TABLE)->where($map)->count();
        //计算pp
        $pp = ceil($count / $num) < $pp ? ceil($count / $num) : $pp;
        //查询数据
        $list = Db::name(self::TABLE)->where($map)->order("admin_auth_id desc")->page($pp, $num)->field($field)->select();
        return [
            'list' => $list,
            'count' => $count,
            'pp' => $pp
        ];
    }

    /**
     * 权限添加
     *
     * @param array $param 权限信息
     * 
     * @return array
     */
    public static function add($param)
    {
        $param['admin_auth_create_time'] = date('Y-m-d H:i:s');
        $param['admin_auth_update_time'] = date('Y-m-d H:i:s');
        $admin_auth_id = Db::name(self::TABLE)->insertGetId($param);
        if (empty($admin_auth_id)) exception("系统异常添加失败");
        return [
            'admin_auth_id' => $admin_auth_id
        ];
    }

    /**
     * 权限修改
     *
     * @param array $param 权限信息
     * 
     * @return array
     */
    public static function edit($param)
    {
        $admin_auth_id = $param['admin_auth_id'];
        $param['admin_auth_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE)->where('admin_auth_id', $admin_auth_id)->update($param);
        if (empty($res))  exception("权限修改失败");
        return [];
    }

    /**
     * 权限删除
     *
     * @param integer $admin_auth_id 权限id
     * 
     * @return array
     */
    public static function dele($admin_auth_id)
    {
        $res = Db::name(self::TABLE)->delete($admin_auth_id);
        if (empty($res))  exception('删除权限异常');
        return [];
    }
}
