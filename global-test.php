<?php
//网上有人说=》//http://www.php.cn/toutiao-407849.html
// 以下测试 。php5 和php7测试的在f（）结果会不一样，
//然而我亲自测试之后，结果是一样的，有些东西还是要自己试了才知道

$a = 3;
$b = 2;



function f()
{
    global $a,$b;//相当于给$GLOBALS['a'] 起了一个别名$a
    $a = $a+ $b;
    echo "fun f()后a:\n" ;
    echo $a ;
    echo "\n" ;
    unset($a);//仅仅删除了别名 $a，在f里$a 相当于外面的$a的别名，$GLOBALS['a'] 仍然存在
}

function e()
{

    $GLOBALS['a'] += 5;
    echo "fun e()后a:\n" ;
    echo $GLOBALS['a'] ;
    echo "\n" ;
    unset($GLOBALS['a']);//删除了外部的$a
}
echo "第1次 outside echo  a:\n" ;
echo $a;
echo "\n" ;
f();
echo "第2次 outside echo  a:\n" ;
echo $a;
echo "\n" ;
e();

if(isset($a)){
    echo "第3次 outside echo  a:\n" ;
    echo $a;
    echo "\n" ;
}else{
    echo "unset(\$GLOBALS['a'])后 outside \$a 被删除了\n" ;
}


?>