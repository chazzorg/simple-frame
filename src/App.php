<?php

namespace Chazz;

use Chazz\Facades\Request;
use Chazz\Facades\Response;

class App
{
    /**
     * 处理请求
     */
    public function run()
    {
        if(Request::uri() == '/favicon.ico') return ;
        $router        = $this->router(Request::uri());
        $app_namespace = config('app.namespace');
        $module        = $router['m'] ;
        $controller    = $router['c'] ;
        $action        = $router['a'] ;
        $classname     = $app_namespace.$module."\\".$controller."Controller";
        if(class_exists($classname) && method_exists($classname,$action)){
            $class = new $classname;
            if(!empty(ob_get_contents())) {
                ob_end_clean();
            }
            $class->$action();
        }else{
            Response::status(404)->end('404 NOT FOUND');
        }
    }

    /**
     * Http 路由解析
     */
    public function router($request_uri){
        $path = trim($request_uri, '/');
        if(!empty( $router['ext']) && substr($path,-strlen($router['ext'])) == $router['ext'] ){
            $path = substr($path , 0 , strlen($path)-strlen($$router['ext']));
        }
        if (!empty(config('routes'))) {
            foreach (config('routes') as $key => $value) {
                if(substr($path,0,strlen($key)) == $key) {
                    $path = str_replace($key, $value, $path);
                    break;
                }
            }
        }
        $path = explode( "/" , $path)?:[];
        if(count($path) > 2){
            list($module, $controller, $action) = $path;
        }else{
            $router = config('app.router');
            $module 	= $router['m'];
            $controller = $router['c'];
            $action 	= $router['a'];
        }
        return [
            'm'=> convertname($module, true, '-'),
            'c'=> convertname($controller, true, '-'),
            'a'=> config('app.router.prefix') . convertname($action, true, '-')
        ];
    }

}