<?php

/**
 * 应用配置
 */
return [
    'name'      => env('APP_NAME', ''),     //项目名称
    'namespace' => "\\App\\Controllers\\",  //应用命名空间
    'view'      => APP_PATH . 'View/',      //视图模板

    //日志
    'log' => [
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别，共8个级别，1=>debug，2=>info，4=>warn，8=>error,
        'level' => 2,
    ],

    //路由配置
    'router' => [
        'm'             => 'home',     //默认模块
        'c'             => 'index',    //默认控制器
        'a'             => 'index',    //默认操作方法
        'ext'           => '.html',    //url后缀    例如 .html
        'prefix'        => 'action',   //操作方法前缀  例如 actionIndex
    ],

];
