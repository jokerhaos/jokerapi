<?php
// +----------------------------------------------------------------------
// | Session设置
// +----------------------------------------------------------------------

return [
    // session name
    'name'           => 'XIAOHAOBIZHISESSIONID',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // 驱动方式 支持file cache
    'type'           => 'cache',
    // 存储连接标识 当type使用cache的时候有效
    'store'          => 'redis',
    // 过期时间
    'expire'         => 1800,
    // 前缀
    'prefix'         => 'bz_',
];
