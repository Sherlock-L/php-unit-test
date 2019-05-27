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
    private $argv;
    private $remark;

    /**
     * @description
     * @param  mixed $params  如果执行方法包含多个参数 如 function a ($a,$b,$c)  可以将 $params = [1,4,6]来传递，
     * 如果单个参数 可直接传一个非数组的值过来，如果是单个参数,且参数为数组 则传array(array())
     */
    public function __construct($object, $functionName, $params = null, $remark = "异步执行方法")
    {
        $this->object       = $object;
        $this->functionName = $functionName;
        $this->argv         = $params;
        $this->remark       = $remark;
    }

    public function handle()
    {
        Log::info("asyExecFunction::start");
        try {
            Log::info($this->remark);
            $obj      = $this->object;
            $function = $this->functionName;
            $functionVariable = [$obj,$function];
            if(is_callable($functionVariable)){
                if (empty($this->argv)) {
                    call_user_func($functionVariable);
                } else {
                    if(is_array($this->argv)){
                        $obj->{$function}(...$this->argv);
                    }else{
                        $obj->{$function}($this->argv);
                    }
                }
            }else{
                throw new \Exception("{$function} is not  callable");
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


