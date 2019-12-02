<?php

namespace App\Http\Controller;

use App\Http\Model\User;
use App\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\View\ViewServiceProvider;

class LswController
{
    public function test()
    {
        return '<hl>lsw::test控制器成功！';
    }


    //手动写了一个Request ，主动 createFromGlobals ,因为这里没有获得全局容器里的Request 的实例，
    public function user(Request $request)
    {
        var_dump($request->params->toArray());
        return json_encode(['data' => User::find($request->params->uid)]);
    }

//TODO 解决构造view 有问题，可能升级了，
    public function testView(Request $request)
    {
        $app     = Container::getInstance();
        $factory = $app->make('view');
        $user    = User::find($request->params->uid);
        return $factory->make('test')->with('data', $user);
    }

}



