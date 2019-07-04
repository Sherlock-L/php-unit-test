<?php
namespace test;  
 //如果不想手动 require ，可以自己实现auload ，利用 spl_autoload_register 函数 https://www.php.net/manual/zh/function.spl-autoload-register.php
//require "./util/util.php";//不可以重复use 引用 Cannot declare 会报错  https://www.php.net/manual/zh/language.namespaces.importing.php
//require "./util/debug.php";
spl_autoload_register(function($class){
    echo "$class is not require ,now try autoload spl_autoload_register \n";
    //TODO 根据$class 解析得到命名空间，和类名，然后去转化到对应目录，所以psr-4规范 很重要
    require $class . '.php';
});


use util\debug as debug2;
use util;//可以重复use 引用
class debug {
   public static function sayHello(){
      print("Hello,".__NAMESPACE__."\n");
   }
}



debug::sayHello();
debug2::sayHello();
util\debug::sayHello();
util\util::sayHello();



