<?php 

//https://zhidao.baidu.com/question/200822684.html   位运算符
$a = 1;

$a =1;
echo sprintf("%b", $a);//打印结果1  其实前面的0被忽略了
echo "\n";
echo sprintf("%b", ~$a);//求反运算符 ,结果为11111111111111111111111111111110  4个字节长度，

echo "\n";
echo sprintf("%d", ~$a);//打印结果为2，这是因为计算机是以补码存储的，所以11111111111111111111111111111110 原码就是2 （减一，然后所有位取反）

//为什么使用反码存储 https://blog.csdn.net/qq_41727218/article/details/79521759