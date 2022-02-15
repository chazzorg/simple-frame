#!/usr/bin/env php
<?php

// 应用入口
define('RUN_IN', 'CMD');

//加载composer组件
require __DIR__ ."/vendor/autoload.php";

//加载公共环境配置
require __DIR__ ."/src/common.php";

//加载脚本
require "app/Console/Kernel.php";

//执行命令
(new App\Console\Kernel())->run();