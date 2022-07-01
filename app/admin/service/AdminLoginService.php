<?php
/*
 * @Description  : 登录退出
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-05
 * @LastEditTime : 2021-01-04
 */

namespace app\admin\service;

use think\facade\Db;
use app\admin\service\AdminMenuService;
use app\common\cache\AdminLoginCache;
use app\common\lib\Encryption;
use Exception;

class AdminLoginService
{
    /**
     * 登录
     *
     * @param array $param 登录信息
     * 
     * @return array
     */
    public static function login($param)
    {
        try {
            //获取账户资料
            $userInfo = Db::name("admin_user")->where("admin_user_number", $param['admin_user_number'])->find();
            if (empty($userInfo)) throw new Exception("账号或者密码错误");
            $pwd = Encryption::enMd5($param['admin_user_pwd'], $userInfo['admin_user_salt']);
            if ($pwd !== $userInfo['admin_user_pwd']) throw new Exception("账号或者密码错误");
            if ($userInfo['admin_user_status'] !== 1) throw new Exception('账号被禁用，请联系管理员');
            //获取角色资料
            $roleInfo = Db::name("admin_role")->where("admin_role_id", $userInfo['admin_role_id'])->find();
            if (empty($roleInfo)) throw new Exception("用户没绑定角色");
            if ($roleInfo['admin_role_status'] !== 1) throw new Exception("角色被禁用");
            $menuWhere = [];
            $authWhere = [];
            //判断是否是超管
            if ($userInfo['admin_user_is_admin'] !== 1) {
                //判断用户有没有自定义菜单
                if (empty($userInfo['admin_menu_id'])) {
                    //使用角色菜单
                    $menuWhere[] = ['admin_menu_id', 'in', $roleInfo['admin_menu_id']];
                } else {
                    //使用用户菜单
                    $menuWhere[] = ['admin_menu_id', 'in', $userInfo['admin_menu_id']];
                }
                //判断用户有没有自定义权限
                if (empty($userInfo['admin_auth_id'])) {
                    //使用角色权限
                    $authWhere[] = ['admin_auth_id', 'in', $roleInfo['admin_auth_id']];
                } else {
                    //使用用户权限
                    $authWhere[] = ['admin_auth_id', 'in', $userInfo['admin_auth_id']];
                }
            }
            $menuInfo = AdminMenuService::findList($menuWhere);
            $authList = Db::name("admin_auth")->where($authWhere)->select();
            $authArr = [];
            foreach ($authList as $k => $value) {
                $authArr[$value['admin_auth_id']] = $value['admin_auth_path'];
            }
            $authInfo = [
                'authList' => $authList,
                'authArr' => $authArr
            ];
            //生成redis.KEY
            $redisKey = time() . randomkeys(5) . $userInfo['admin_user_id'];
            $tokenData = [
                'admin_user_id' => $userInfo['admin_user_id'],
                'redis_key'     => $redisKey,
                'login_time'    => date("Y-m-d H:i:s"),
                'login_ip'      => $param['request_ip'],
            ];
            $token = AdminTokenService::create($tokenData);
            if (!$token) throw new Exception("token生成失败！");
            //redis存储API接口权限数据、和登陆数据
            AdminLoginCache::set($userInfo['admin_user_id'], $authInfo, $token, $redisKey);
            return success([
                'menu'  => $menuInfo,
                'token' => $token,
                'user'  => [
                    'admin_user_id'       => $userInfo['admin_user_id'],
                    'admin_user_name'     => $userInfo['admin_user_name'],
                    'admin_user_number'   => $userInfo['admin_user_number'],
                    'admin_user_is_admin' => $userInfo['admin_user_is_admin'],
                    'redis_key'           => $redisKey
                ]
            ]);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    /**
     * 退出
     *
     * @param integer $admin_user_id 用户id
     * 
     * @return array
     */
    public static function logout($admin_user_id, $redisKey = '')
    {
        try {
            AdminLoginCache::del($admin_user_id, $redisKey);
            return success([], '退出成功');
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }
}
