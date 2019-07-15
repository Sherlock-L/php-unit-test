<?php
//https://www.php.net/manual/zh/language.operators.precedence.php 优先级
$b = 1;
$c = 3;
$a =!$c ** $b;  //8的 3次方
echo $a ; //结果为空 因为  **  优先级比!高

echo "第二次 \n";
$a = $c and $b;  //8的 3次方
echo $a ; //结果为3  先执行 =  后执行  and  根据优先级