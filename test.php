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

class T {
}

class test extends T {

}

    $a = new test();
    $b = new t();


    if($a  instanceof T){
        echo 666;  //TRUE 
    }

    if($b  instanceof test){
        echo 777; //FALSE
    }