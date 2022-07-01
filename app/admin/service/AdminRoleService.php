<?php
/*
 * @Description  : 角色管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use think\facade\Db;

class AdminRoleService
{
    const TABLE = 'admin_role';
    /**
     * 查询条件
     *
     * @param array   $data   参数
     * 
     * @return array 
     */
    private static function map(array $data){
        $map = [];
        if($data['admin_role_code']){
            $map['admin_role_code'] = $data['admin_role_code'];
        }
        if($data['admin_role_name']){
            $map['admin_role_name'] = $data['admin_role_name'];
        }
        if($data['admin_role_status']){
            $map['admin_role_status'] = $data['admin_role_status'];
        }
        if($data['start_time'] && $data['end_time']){ //交易时间
            $map['admin_role_create_time'] = array(array("egt",$data['start_time']),array("elt",$data['end_time']));
        }
        return $map;
    }

    /**
     * 角色列表
     *
     * @param array   $param   参数
     * @param integer $page    页数
     * @param integer $limit   数量
     * @param string  $field   字段
     * @param boole  $getAll   是否获取所有字段和数据
     * 
     * @return array 
     */
    public static function findList($param = [], $pp = 1, $num = 10, $field = '',$getAll = false)
    {
        if($getAll){
            return [
                'list' => Db::name(self::TABLE)->order("admin_role_id desc")->field($field)->select()
            ];
        }
        //查询条件
        $map = self::map($param);
        $count = Db::name(self::TABLE)->where($map)->count();
        //计算pp
        $pp = ceil($count / $num) < $pp ? ceil($count / $num) : $pp;
        //查询数据
        $list = Db::name(self::TABLE)->where($map)->order("admin_role_id desc")->page($pp,$num)->field($field)->select();
        return [
            'list' => $list,
            'count' => $count,
            'pp' => $pp
        ];
    }


    /**
     * 角色添加
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function add($param = [])
    {
        $param['admin_role_status']      = 1;
        $param['admin_role_create_time'] = date('Y-m-d H:i:s');
        $param['admin_role_update_time'] = date('Y-m-d H:i:s');
        $admin_role_id = Db::name('admin_role')->insertGetId($param);
        $param['admin_role_id'] = $admin_role_id;
        return [
            'admin_role_id' => $admin_role_id
        ];
    }

    /**
     * 角色修改
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function edit($param = [])
    {
        $admin_role_id = $param['admin_role_id'];
        $param['admin_role_update_time']    = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE)->where('admin_role_id', $admin_role_id)->update($param);
        if (empty($res))   exception();
        return [
            'msg' => '修改成功'
        ];
    }

    /**
     * 角色删除
     *
     * @param array $admin_role_id 角色id
     * 
     * @return array
     */
    public static function dele($admin_role_id)
    {
        $res = Db::name(self::TABLE)->delete($admin_role_id);
        if(!$res) exception('删除失败');
        return ['msg'=>'删除成功'];
    }

    /**
     * 角色状态修改
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function roleStatusUpdate($param)
    {
        $admin_role_id = $param['admin_role_id'];
        $param['admin_role_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_role_id', $admin_role_id)->update($param);
        if (empty($res)) exception('状态修改失败');
        return [];
    }

    /**
     * 角色菜单分配
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function roleMenu($param)
    {
        $admin_role_id = $param['admin_role_id'];
        $param['admin_role_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_role_id', $admin_role_id)->update($param);
        if (empty($res)) exception('菜单分配失败');
        return [];
    }

    /**
     * 角色权限分配
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function roleAuth($param)
    {
        $admin_role_id = $param['admin_role_id'];
        $param['admin_role_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_role_id', $admin_role_id)->update($param);
        if (empty($res)) exception('权限分配失败');
        return [];
    }
}
