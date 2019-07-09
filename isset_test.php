<?php
/**
 * isset()函数测试，如果没仔细看官方文档，仅仅字面理解，一部分人理解应该是“变量只要设置了，无论何值，哪怕没有值，一样返回true”
 * 但是对于null 值的变量，则返回false ，虽然看似这个变量满足字面理解“被设置”。所以使用任何函数好好看说明书。。
 * 官方解释是isset — 检测变量是否已设置并且非 NULL   https://www.php.net/manual/zh/function.isset.php
 */
class test{
        public $a;
        public static $b;
        public $c = 1;
        public static $d =1;

}

$obj = new test();
if(isset($obj->a)){ //结果为false ，因为在类里虽然声明了，但是并没有赋予对应的值
    echo 'isset $obj->a is true';
    echo "\n";
}else{
    echo 'isset $obj->a is not  true';
    echo "\n";
}
if(isset($obj->c)){  //结果为false ，因为在类里虽然声明了，且有不为null 的值
    echo 'isset $obj->c is true';
    echo "\n";
}else{
    echo 'isset $obj->c is not  true';
    echo "\n";
}

if(isset(test::$b)){  //结果为false ，因为在类里虽然声明了，但是并没有赋予对应的值
    echo 'isset test::$b is true';
    echo "\n";
}else{
    echo 'isset test::$b is not  true';
    echo "\n";
}

if(isset(test::$d)){  //结果为true ，因为isset 里变量有值，且不为null
    echo 'isset test::$d is true';
    echo "\n";
}else{
    echo 'isset test::$d is not  true';
    echo "\n";
}

$obj->c = null;

if(isset($obj->c)){ //结果为false ，因为isset 里变量值为null 
    echo 'isset $obj->c is true after $obj->c = null ';
    echo "\n";
}else{
    echo 'isset $obj->c is not  true after $obj->c = null ';
    echo "\n";
}