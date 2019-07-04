<?php
namespace util;
class debug{
  static function sayHello(){
    print("Hello,".'debug.php'."\n");
    print("Hello,class debug namespace is ".__NAMESPACE__."\n");  }
}