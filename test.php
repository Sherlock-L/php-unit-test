<?php
namespace test;  
 //如果不想手动 require ，可以自己实现auload ，利用 spl_autoload_register 函数 https://www.php.net/manual/zh/function.spl-autoload-register.php

 //require "./util/util.php";//重复require ，如果包含类或者function   会报错 Cannot declare  https://www.php.net/manual/zh/language.namespaces.importing.php
//require "./util/debug.php";

/*TODO 根据$class 解析得到命名空间，和类名，然后去转化到对应目录，所以psr-4规范 很重要
   命名空间格式和目录结构保持一致、以及文件名和类名一致、方面动态require 时更简单的定位目标。
   部分的第三方包也会在其内部目录定义自己的autoload*/ 
spl_autoload_register(function($class){
    echo "$class is not require ,now try autoload spl_autoload_register \n";
  
    require $class . '.php';
});



use util\debug as debug2;//修改别名 因为会和当前类名称冲突  
use util ;//引入该命名空间
use util as ualias;//为类名称使用别名、为接口使用别名或为命名空间名称使用别名
class debug {
   public static function sayHello(){
      print("Hello,".__NAMESPACE__."\n");
   }
}



debug::sayHello();
debug2::sayHello();
util\debug::sayHello();
util\util::sayHello();
ualias\util::sayHello();



