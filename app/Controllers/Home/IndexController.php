<?php
namespace App\Controllers\Home;

use Chazz\Controllers\Controller;
use Chazz\Facades\Request;
use Chazz\Facades\Response;
use Chazz\Facades\Redis;
use Chazz\Facades\Db;

class IndexController extends Controller
{
    public function actionIndex()
    {
        echo 11111;
    }
}