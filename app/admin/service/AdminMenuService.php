<?php
/*
 * @Description  : 菜单管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use think\facade\Db;
use Exception;

class AdminMenuService
{
    const TABLE = 'admin_menu';
    /**
     * 菜单列表
     * @param array $where 寻找条件
     * @return array 
     */
    public static function findList($where = [])
    {
        $order = ['admin_menu_sort' => 'desc', 'admin_menu_id' => 'asc'];
        $list = Db::name(self::TABLE)->order($order)->where($where)->column("*","admin_menu_id");
        $tree = self::toTree($list, 0);
        return [
            'list' => $list,
            'tree' => $tree,
            'count' => count($list)
        ];
    }

    /**
     * 菜单添加
     *
     * @param array $param 菜单信息
     * 
     * @return array
     */
    public static function add($param)
    {
        Db::startTrans();
        try {
            $param['admin_menu_create_time'] = date('Y-m-d H:i:s');
            $param['admin_menu_update_time'] = date('Y-m-d H:i:s');
            $admin_menu_id = Db::name(self::TABLE)->insertGetId($param);
            if (empty($admin_menu_id)) throw new Exception('系统异常，添加失败');
            //为了确保并发问题出错，就不进行函数一次性插入路径
            $admin_menu_level_path  = $param['admin_menu_level_path'].','.$admin_menu_id;
            $result = Db::name(self::TABLE)->where("admin_menu_id",$admin_menu_id)->update(['admin_menu_level_path'=>$admin_menu_level_path]);
            if(!$result) throw new Exception('系统异常，添加失败');
            //提交事务
            Db::commit();
            return $param;
        } catch (\Exception $e) {
            Db::rollback();
            exception($e->getMessage());
        }
    }

    /**
     * 菜单详情
     * @param integer $admin_menu_id
     * 
     * @return array
     */
    public static function info($admin_menu_id){
        $info = Db::name(self::TABLE)->where("admin_menu_id",$admin_menu_id)->find();
        return $info;
    }

    /**
     * 菜单修改
     *
     * @param array  $param  菜单信息
     * 
     * @return array
     */
    public static function edit($param)
    {
        $param['admin_menu_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name('admin_menu')->where('admin_menu_id',$param['admin_menu_id'])->update($param);
        if (empty($res)) exception('系统异常，修改失败！！！');
        return $param;
    }

    /**
     * 菜单删除
     *
     * @param string $admin_menu_id 菜单id集合
     * 
     * @return array
     */
    public static function dele($ids)
    {
        if(!$ids) exception("请传入ID集合！");
        $res = Db::name(self::TABLE)->whereIn('admin_menu_id',$ids)->delete();
        if(!$res) exception('系统异常，删除失败！！！');
        return [];
    }

    /**
     * 菜单树形获取
     *
     * @param array   $admin_menu 所有菜单
     * @param integer $menu_pid   菜单父级id
     * 
     * @return array
     */
    public static function toTree($admin_menu, $menu_pid)
    {
        $tree = [];
        foreach ($admin_menu as $k => $v) {
            if ($v['admin_menu_pid'] == $menu_pid) {
                $v['children'] = self::toTree($admin_menu, $v['admin_menu_id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}
