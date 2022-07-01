<?php
// +----------------------------------------------------------------------
// | 数据库配置
// +----------------------------------------------------------------------

return [
    // 默认使用的数据库连接配置
    'default'         => env('database.driver', 'newgm'),

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
            'type'              => env('NEWGM_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => env('NEWGM_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => env('NEWGM_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => env('NEWGM_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => env('NEWGM_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => env('NEWGM_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => env('NEWGM_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => env('NEWGM_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => env('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => env('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => env('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'hero' => [
            // 数据库类型
            'type'              => env('HREO_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => env('HREO_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => env('HREO_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => env('HREO_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => env('HREO_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => env('HREO_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => env('HREO_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => env('HREO_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => env('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => env('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => env('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'gmt' => [
            // 数据库类型
            'type'              => env('GMT_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => env('GMT_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => env('GMT_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => env('GMT_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => env('GMT_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => env('GMT_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => env('GMT_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => env('GMT_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => env('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => env('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => env('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],
        'login' => [
            // 数据库类型
            'type'              => env('LOGIN_DATABASE.type', 'mysql'),
            // 服务器地址
            'hostname'          => env('LOGIN_DATABASE.hostname', '127.0.0.1'),
            // 数据库名
            'database'          => env('LOGIN_DATABASE.database', 'yyladmin'),
            // 用户名
            'username'          => env('LOGIN_DATABASE.username', 'yyladmin'),
            // 密码
            'password'          => env('LOGIN_DATABASE.password', 'yyladmin'),
            // 端口
            'hostport'          => env('LOGIN_DATABASE.hostport', '3306'),
            // 数据库连接参数
            'params'            => [],
            // 数据库编码默认采用utf8
            'charset'           => env('LOGIN_DATABASE.charset', 'utf8'),
            // 数据库表前缀
            'prefix'            => env('LOGIN_DATABASE.prefix', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'            => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'       => false,
            // 读写分离后 主服务器数量
            'master_num'        => 1,
            // 指定从服务器序号
            'slave_no'          => '',
            // 是否严格检查字段是否存在
            'fields_strict'     => env('app_debug', false),
            // 是否需要断线重连
            'break_reconnect'   => false,
            // 监听SQL
            'trigger_sql'       => env('app_debug', false),
            // 开启字段缓存
            'fields_cache'      => env('database.fieldscache', false),
            // 字段缓存路径
            'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
        ],

    ],
];
