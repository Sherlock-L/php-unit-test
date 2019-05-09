<?php

/**
 * @description  ###基于laravel框架，使用队列，实现异步执行任务的通用类###
 */

namespace App\Jobs;

//基于  laravel 框架 的依赖
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

//
//  将AsyExecFunction实例 发布到  laravel 队列中，实现异步操作
class AsyExecFunction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //实例 化后的对象
    private $object;
    //方法名
    private $functionName;
    //如果是参数数组，数据键值顺序按照function所定义的参数循序从左到右排列
    //如果不是数组
    private $argv;
    private $remark;

    public function __construct($object, $functionName, $params = null, $remark = "异步执行方法")
    {
        $this->object       = $object;
        $this->functionName = $functionName;
        $this->argv         = $params;
        $this->remark       = $remark;
    }

    public function handle()
    {
        try {
            Log::info("asyExecFunction::start");
            Log::info($this->remark);
            $obj      = $this->object;
            $function = $this->functionName;
            if (empty($this->argv)) {
                $obj->$function();
            } else {
                if (is_array($this->argv)) {
                    $obj->$function(...$this->argv);
                } else {
                    $obj->$function($this->argv);
                }
            }
            //TODO 支持params 类型未匿名函数
        } catch (\Exception $e) {
            $logInfo = "{$e->getMessage()} code-line:{$e->getLine()} code-file:{$e->getFile()}";
            Log::error($logInfo);
        }
        Log::info("asyExecFunction::end");
    }
}

/*********基于laravel框架， 使用其dispatch()方法来发布异步执行AsyExecFunction实例**********/
class Test{
    public function add($a,$b){
        echo $a+$b;
    }

    public function varDumpObj($obj){
       var_dump($obj);
    }


    public function noParam(){

    }

    //直接在函数内调用
    public function  doAsyFun(){
        $params = [333,134];
        dispatch((new AsyExecFunction($this,'add',$params,'调用add()方法')));
    }
}

//使用样例
$test = new Test();
dispatch((new AsyExecFunction($test,'noParam',null,'noParam()方法')));


