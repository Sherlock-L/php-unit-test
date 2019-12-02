<?php 
namespace app;

use util\debug;
//https://www.php.net/manual/zh/book.reflection.php 官方文档
//https://www.cnblogs.com/fps2tao/p/10393755.html  参考博客
//自动加载类
spl_autoload_register(function($class){
    echo "$class is not require ,now try autoload spl_autoload_register \n";
    require $class . '.php';
});

class test {
    private $a;
    public $b;
    protected $c=1;
    const name = 'liushuuwen';
    const age =18;
    public static $money ;
    public function __construct(debug $debug,$a=1){
        echo "test类执行构造方法";
        var_dump("参数为：", $debug,$a);
    }

    public  static function  getName(){
        return self::name;
    }
    public function  sayHello($a,$e,$b=1,$c=2){

    }
}

// \Reflection::export(new \ReflectionClass('app\test'));//导出类的完整描述

$ref = new \ReflectionClass('app\test');
// var_dump('getConstants::',$ref->getConstants());
// var_dump('getConstant::',$ref->getConstant('age'));
// var_dump('getConstructor::',$ref->getConstructor());
// var_dump('getDefaultProperties::',$ref->getDefaultProperties());//获取类默认属性
// var_dump('getMethods::',$ref->getMethods());//获取方法数组


$con = $ref->getConstructor();
var_dump('getConstructor::',$con);
$params = $con ->getParameters();

$initparams = [];
foreach($params as $v){
   $temp = $v->getClass();//此处要自动加载要开启，否则如果参数是类，可能会报找不到某个类
    if(is_null($temp)){
        $initparams[]=    $v->isDefaultValueAvailable() ? $v->getDefaultValue() : NULL;

    }else{
        $initparams[] = $temp->newInstanceArgs();//构造函数的参数是否个类，自动实例化，这里假设参数所对应的类构造函数没有依赖别的参数，否则依然要想办法拼参数
    }
}
var_dump('initparams::',$initparams);
var_dump('通过反射类最终自动实例化了类：:',$ref->newInstanceArgs($initparams));//实例化

// ReflectionFunctionAbstract::getNumberOfParameters — 获取参数数目
// ReflectionFunctionAbstract::getNumberOfRequiredParameters — 获取必须输入参数个数
// ReflectionFunctionAbstract::getParameters — 获取参数