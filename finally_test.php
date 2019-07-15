<?php
error_reporting(0);
//https://www.php.net/manual-lookup.php?pattern=finally&scope=quickref
 function  a(){
    try { 
        return "888\n";//执行
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        echo "a finally.\n"; //执行
    }
    return "999\n"; //不执行 ，因为之前已经return 了
    
 }

 function  b(){
    try { 
        throw new Exception("手动异常");
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n"; //执行
    } finally {
        echo "b finally.\n"; //执行
    }
    
 }

echo a(); //finally 执行
echo b();//finally 执行

/** 执行结果  
a finally.
888
Caught exception: 手动异常
b finally.
 */