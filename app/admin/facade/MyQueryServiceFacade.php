<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\admin\facade;

use think\Facade;

/**
 * @see \app\admin\service\MyQueryService
 * @method static array paginate(') 
 * @method static string getTable(string $name) 
 * @method static \app\admin\service\MyQueryService setTable(string $name = null, mixed $default = null)
 */
class MyQueryServiceFacade extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\admin\service\MyQueryService';
    }
}
