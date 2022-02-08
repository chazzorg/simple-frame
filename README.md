# simple-frame

# 极简、快速、透明，简单快速搭建web框架simple-frame
===================

安装

```shell
cd simple-frame
composer install
cp .env.example .env
```

## 快速上手
##### 环境变量
编辑根目录下`.env`文件，快速配置`数据库` `redis`连接地址

##### 路由
访问地址组成: http://xxx.com/模块/控制器/方法
命名采用`大驼峰法`命名方式，除了首字母，其他大写字母需要通过`-`连接，
例如：模块是TaoBao,控制器MyShop,方法AddGoods
路由就是：http://xxx.com/tao-bao/my-shop/add-goods
控制器文件需要在后面加上`Controller`，文件内方法命名需要在前面加上`action`
模块目录名为：TaoBao
控制器文件名为：MyShopController.php
方法为：actionAddGoods

##### 命令行
在app\Console\Commands目录下创建脚本文件，文件名和类名要保持一致,直接执行定义的命令
```shell
cd simple-frame
php cmd test
```