<?php
echo "初始: ".memory_get_usage()." 字节 <br>:";
$array = range(1, 100000);
$a  = $array;
echo "赋值a时: ".memory_get_usage()." 字节  <br>";
function dummy($array) {
    echo "循环时内存: ".memory_get_usage()." 字节  <br>";
}

$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array);
}
printf("Used %sS <br>", microtime(true) - $start);

$b = &$array; //注意这里, 假设我不小心把这个Array引用给了一个变量
echo "赋值b时: ".memory_get_usage()." 字节  <br>";

$c = &$array;
echo "赋值c时: ".memory_get_usage()." 字节  <br>";


$e = $array;
echo "赋值e时: ".memory_get_usage()." 字节  <br>";


$b[] = 1;
echo "修改b时: ".memory_get_usage()." 字节  <br>";
$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array);

}


