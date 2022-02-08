<?php

//加载composer组件
require __DIR__ ."/vendor/autoload.php";

//加载公共配置
require __DIR__ ."/src/common.php";

//启动
(new Chazz\App())->run();