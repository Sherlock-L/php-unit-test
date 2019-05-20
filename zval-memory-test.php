<?php
echo "初始: ".memory_get_usage()." 字节 <br>:";

$array = range(1, 100000);
xdebug_debug_zval('array');
$a  = $array;

echo "赋值a时: ".memory_get_usage()." 字节  <br>";
xdebug_debug_zval('a');
xdebug_debug_zval('array');
function dummy($tmp) {
    echo "循环时内存: ".memory_get_usage()." 字节  <br>";
    xdebug_debug_zval('tmp');
}

$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array);

}
printf("Used %sS <br>", microtime(true) - $start);

$b = &$array; //注意这里, 假设我不小心把这个Array引用给了一个变量
echo "赋值b = &array时: ".memory_get_usage()." 字节  <br>";
xdebug_debug_zval('a');
xdebug_debug_zval('array');
xdebug_debug_zval('b');



$b[] = 1;
echo "修改b时: ".memory_get_usage()." 字节  <br>";
xdebug_debug_zval('a');
xdebug_debug_zval('array');
xdebug_debug_zval('b');
$c = &$array;
echo "赋值c=&array时: ".memory_get_usage()." 字节  <br>";
xdebug_debug_zval('a');
xdebug_debug_zval('array');
xdebug_debug_zval('b');
xdebug_debug_zval('c');

$d = $array;
echo "赋值d=array时: ".memory_get_usage()." 字节  <br>";
xdebug_debug_zval('a');
xdebug_debug_zval('array');
xdebug_debug_zval('b');
xdebug_debug_zval('c');
xdebug_debug_zval('d');
$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array);

}

printf("Used %ss <br>", microtime(true) - $start);