<?php
// +----------------------------------------------------------------------
// | 数据库配置
// +----------------------------------------------------------------------

use think\facade\Env;

return [
    // 默认使用的数据库连接配置
    'default'         => Env::get('database.driver', 'newgm'),

    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    // true为自动识别类型 false关闭
    // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
    'auto_timestamp'  => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 数据库连接配置信息
    'connections'     => [
        'newgm' => [
            // 数据库类型
            'type'              => Env::get('NEWGM_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => Env::get('NEWGM_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => Env::get('NEWGM_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => Env::get('NEWGM_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => Env::get('NEWGM_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => Env::get('NEWGM_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => Env::get('NEWGM_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => Env::get('NEWGM_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => Env::get('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => Env::get('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => Env::get('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'hero' => [
            // 数据库类型
            'type'              => Env::get('HREO_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => Env::get('HREO_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => Env::get('HREO_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => Env::get('HREO_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => Env::get('HREO_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => Env::get('HREO_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => Env::get('HREO_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => Env::get('HREO_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => Env::get('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => Env::get('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => Env::get('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'gmt' => [
            // 数据库类型
            'type'              => Env::get('GMT_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => Env::get('GMT_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => Env::get('GMT_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => Env::get('GMT_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => Env::get('GMT_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => Env::get('GMT_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => Env::get('GMT_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => Env::get('GMT_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => Env::get('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => Env::get('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => Env::get('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'login' => [
            // 数据库类型
            'type'              => Env::get('LOGIN_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => Env::get('LOGIN_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => Env::get('LOGIN_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => Env::get('LOGIN_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => Env::get('LOGIN_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => Env::get('LOGIN_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => Env::get('LOGIN_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => Env::get('LOGIN_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => Env::get('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => Env::get('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => Env::get('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],

    ],
];
