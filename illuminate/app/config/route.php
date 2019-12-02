<?php 
//此处$app 从全局拿的，所以全局要定义一个容器 变量 $app
$app['router']->get("/", function(){
    return "hell world!";});

$app['router']->get("lsw/test", 'App\Http\Controller\LswController@test');
$app['router']->get("lsw/user", 'App\Http\Controller\LswController@user');
$app['router']->get("lsw/testView", 'App\Http\Controller\LswController@testView');

//TODO 中间件