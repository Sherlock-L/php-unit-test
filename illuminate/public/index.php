<?php 
require __DIR__."/../vendor/autoload.php";
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Fluent;
$app = new Illuminate\Container\Container;
//注册views
Illuminate\Container\Container::setInstance($app);
$app->instance('config', new Fluent);
$app['config']['view.compiled'] = 'D:/1/htdocs/php-test/illuminate/storage';
$app['config']['view.paths'] = ['D:/1/htdocs/php-test/illuminate/app/resources/views'];
with (new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

//基础路由、事件服务注册
with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();
//实例化数据库 管理 Eloquent ORM
$manager = new Manager($app);
$manager->addConnection(require '../app/config/database.php');
$manager->bootEloquent();
//加载路由
require	__DIR__.'/../app/config/route.php';
//实例化请求 利用symfony 的  createFromGlobals
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);
//返回请求响应
$response->send();

