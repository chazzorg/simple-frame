<?php

use Dotenv\Dotenv;
use Chazz\Log\CLogFileHandler;
use Chazz\Log\Log;

// 设置时区
date_default_timezone_set('Asia/Shanghai');

// 站点目录
define ('CODE_PATH',__DIR__.'/../');

// 应用目录
define ('APP_PATH',__DIR__.'/../app/');

//配置目录
define ('CONFIG_PATH',__DIR__ .'/../config/');

//日志路径
define('LOG_PATH',__DIR__ .'/../logs/');

//加载.env环境配置
if(!is_file(CODE_PATH . '.env')){
    exit('请在根目录下创建.env文件');
}
$dotenv = Dotenv::createImmutable(CODE_PATH);
$dotenv->load();

// 初始化日志
if(RUN_IN == 'CMD'){
    $logHandler = new CLogFileHandler(config('app.log.path') . date('Y-m-d') . '.cmd.log');
}else{
    $logHandler = new CLogFileHandler(config('app.log.path') . date('Y-m-d') . '.http.log');
}
Log::Init($logHandler, config('app.log.level'));

// 错误报告新显示
if(env('APP_DEBUG')){
    error_reporting(E_ALL);
}else{
    error_reporting(0);
}