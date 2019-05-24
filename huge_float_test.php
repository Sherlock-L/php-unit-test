<?php 
//有时候我们的数字的值会很大，小数点也很多，又不想用科学技术法表示，我们可以将数字转成字符串包裹起来，保证精度不丢失
//同时php 还提供了数学函数，专门处理这些巨大的数字  https://www.php.net/manual/zh/function.bcadd.php
// error_reporting(3);
$a = "10000000000000000000000000000000000000000000000000000000.10000000000";//保持精度，用字符串保存
$b = "99999999999999999999999999999999999999999999999999999999.00000000001";
echo "a:\n";
echo $a ;
echo "\n";
echo "b:\n";
echo $b ;
echo "\n";
echo "普通加法计算a+b：\n";
echo ($a+$b);//会转成科学计数法   
echo "\n";

echo "内置加法函数计算bcadd(\$a,\$b)：\n";
echo bcadd($a,$b,30); //相加 php 内置而数学函数，返回字符串，第三个参数是小数点的位数  
echo "\n";

echo "普通乘法法计算\$a*\$b：\n";
echo ($a*$b);//会转成科学计数法   
echo "\n";

echo "内置乘法函数计算bcmul(\$a,\$b,30)：\n";
echo bcmul($a,$b,30); //相加 php 内置而数学函数，返回字符串，第三个参数是小数点的位数 
echo "\n";
$c = "1.5ac1";
$d = "02.5xxx"; 
echo ($c+$d); //php7下php会发出notice 结果是4  因为php 匹配到02.5+1.5
echo "\n";


$c = "ac1";
$d = "xxx"; 
echo ($c+$d); //php7下php会发出warning警告 结果是0，因为碰到字符之前  ，没有匹配到数字，就认为是0+0
echo "\n";

/****
    都报出来: error_reporting(1); 
　　不要报NOTICE: error_reporting(3); 
　　任何错误都不报: error_reporting(0); 
 */

