<?php
/*
 * @Description  : 用户管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use app\common\lib\Encryption;
use think\facade\Db;

class AdminUserService
{
    const TABLE = "admin_user";

    /**
     * 查询条件
     *
     * @param array   $data   参数
     * 
     * @return array 
     */
    private static function map(array $data){
        $map = [];
        if($data['admin_user_number']){
            $map['admin_user_number'] = $data['admin_user_number'];
        }
        if($data['admin_user_name']){
            $map['admin_user_name'] = $data['admin_user_name'];
        }
        if($data['admin_user_phone']){
            $map['admin_user_phone'] = $data['admin_user_phone'];
        }
        if($data['admin_user_email']){
            $map['admin_user_email'] = $data['admin_user_email'];
        }
        if($data['admin_user_status']){
            $map['admin_user_status'] = $data['admin_user_status'];
        }
        if($data['start_time'] && $data['end_time']){ //交易时间
            $map['admin_user_create_time'] = array(array("egt",$data['start_time']),array("elt",$data['end_time']));
        }
        return $map;
    }

    /**
     * 用户列表
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
        $list = Db::name(self::TABLE)->where($map)->order("admin_user_id desc")->page($pp,$num)->field($field)->select();
        return [
            'list' => $list,
            'count' => $count,
            'pp' => $pp
        ];
    }

    /**
     * 用户信息
     *
     * @param integer $admin_user_id 用户id
     * 
     * @return array
     */
    public static function info($admin_user_id)
    {
        $data = Db::name(self::TABLE)->where("admin_user_id",$admin_user_id)->find();
        return $data;
    }

    /**
     * 用户添加
     *
     * @param array $param 用户信息
     * 
     * @return array
     */
    public static function add($param)
    {
        $param['admin_user_status'] = 1;
        $param['admin_user_is_admin'] = 2;
        $param['admin_user_create_time'] = date('Y-m-d H:i:s');
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $salt = Encryption::salt(); //加严密钥
        $pwd = Encryption::enMd5($param['admin_user_pwd'],$salt);
        $param['admin_user_salt'] = $salt;
        $param['admin_user_pwd'] = $pwd;
        $admin_user_id = Db::name('admin_user')
            ->insertGetId($param);
        if (empty($admin_user_id)) exception();
        return [
            'admin_user_id' => $admin_user_id
        ];
    }

    /**
     * 用户修改
     *
     * @param array $param 用户信息
     * 
     * @return array
     */
    public static function edit($param)
    {
        $admin_user_id = $param['admin_user_id'];
        if($param['admin_user_email'] == null){
            unset($param['admin_user_email']);
        }
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE)->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res))  exception("用户修改失败");
        return [];
    }

    /**
     * 用户删除
     *
     * @param integer $admin_user_id 用户id
     * 
     * @return array
     */
    public static function dele($admin_user_id)
    {
        $res = Db::name(self::TABLE)->delete($admin_user_id);
        if (empty($res))  exception('删除用户异常');
        AdminLoginService::logout($admin_user_id);
        return [];
    }

    /**
     * 用户是否禁用
     *
     * @param array $param 用户信息
     * 
     * @return array
     */
    public static function isDisable($param)
    {
        $admin_user_id = $param['admin_user_id'];
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res)) exception('用户状态修改失败');
        //要是禁用状态则调用退出登陆接口
        if($param['admin_user_status'] == 2){
            AdminLoginService::logout($admin_user_id);
        }
        return [];
    }

    /**
     * 用户是否管理员
     *
     * @param array $param 用户信息
     * 
     * @return array
     */
    public static function isAdmin($param)
    {
        $admin_user_id = $param['admin_user_id'];
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res)) exception('超管状态修改失败');
        return [];
    }

    /**
     * 用户菜单分配
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function userMenu($param)
    {
        $admin_user_id = $param['admin_user_id'];
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res)) exception('用户菜单分配失败');
        return [];
    }

    /**
     * 用户权限分配
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function userAuth($param)
    {
        $admin_user_id = $param['admin_user_id'];
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res)) exception('用户权限分配失败');
        return [];
    }

    /**
     * 用户登陆密码重置
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function newPwd($param)
    {
        $admin_user_id = $param['admin_user_id'];
        $param['admin_user_update_time'] = date('Y-m-d H:i:s');
        $newPwd = 'xh123456';
        $salt = Encryption::salt(); //加严密钥
        $pwd = Encryption::enMd5($newPwd,$salt);
        $param['admin_user_salt'] = $salt;
        $param['admin_user_pwd'] = $pwd;
        $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($param);
        if (empty($res)) exception('用户密码重置失败');
        AdminLoginService::logout($admin_user_id);
        return ['newPwd'=>$newPwd];
    }

    /**
     * 用户登陆密码修改
     *
     * @param array $param 角色信息
     * 
     * @return array
     */
    public static function editPwd($param)
    {
        //判断用户密码是否正确
        $admin_user_id = $param['admin_user_id'];
        $userInfo = Db::name(self::TABLE)->field("admin_user_pwd,admin_user_salt,admin_user_status")->where('admin_user_id',$admin_user_id)->find();
        $y_pwd = Encryption::enMd5($param['y_pwd'],$userInfo['admin_user_salt']);
        if($y_pwd !== $userInfo['admin_user_pwd']){
            return error('旧密码错误！');
        }else{
            $newPwd = $param['new_pwd'];
            $salt = Encryption::salt(); //加严密钥
            $pwd = Encryption::enMd5($newPwd,$salt);
            $data = [
                'admin_user_update_time' => date('Y-m-d H:i:s'),
                'admin_user_salt' => $salt,
                'admin_user_pwd' => $pwd
            ];
            $res = Db::name(self::TABLE) ->where('admin_user_id', $admin_user_id)->update($data);
            if (empty($res)) exception('用户密码修改失败');
            //修改密码之后调用登陆退出接口清理Session
            AdminLoginService::logout($admin_user_id);
            return success(['newPwd'=>$newPwd]);
        }
    }
}
