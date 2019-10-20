<?php
error_reporting(0);
//https://www.php.net/manual/en/class.iterator.php
//https://www.php.net/manual/zh/reserved.interfaces.php 
/*
遍历
迭代器
聚合式迭代器
数组式访问
序列化
Closure
生成器*/ 
function nums() {
    for ($i = 0; $i < 5; ++$i) {
                //get a value from the caller
        $a = (yield $i);
      
        if($a == 'stop')
        {
            echo "exit\n";
            return;//exit the function
        }
        }    
}

$gen = nums();
// $gen->send('stop');
foreach($gen as $v)
{
    if($v == 3)//we are satisfied
       {$gen->send('stop');
    echo "{$v}\n";
}





