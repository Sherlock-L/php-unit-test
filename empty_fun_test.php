<?php


/**
 * @description 在5.6 、7.1版本中 的空判断  php,  empty 认为 0 "0"都是空，都满足empty() 为true 的条件
 */

function test()
{
    $a = 0;
    if ($a == "") {
        echo '$a = 0  满足条件 if($a == "") <br>';
    } else {
        echo '$a = 0  不满足条件 if($a == "") <br>';
    }

    if ($a === "") {
        echo '$a = 0  满足条件 if($a === "") <br>';
    } else {
        echo '$a = 0  不满足条件 if($a === "") <br>';
    }

    if ($a == "0") {
        echo '$a = 0  满足条件 if($a == "0") <br>';
    } else {
        echo '$a = 0  不满足条件 if($a == "0") <br>';
    }

    if ($a === "0") {
        echo '$a = 0  满足条件 if($a === "0") <br>';
    } else {
        echo '$a = 0  不满足条件 if($a === "0") <br>';
    }

    if ($a == null) {
        echo '$a = 0  满足条件 if($a == null) <br>';
    } else {
        echo '$a = 0  不满足条件 if($a == null) <br>';
    }

    if ($a === null) {
        echo '$a = 0  满足条件 if($a === null) <br>';
    } else {
        echo '$a = 0  不满足条件 if($a === null) <br>';
    }

    if ($a) {
        echo '$a = 0  满足条件 if($a) <br>';
    } else {
        echo '$a = 0  不满足条件 if($a) <br>';
    }

    if (empty($a)) {
        echo '$a = 0  满足条件 if(empty($a)) <br><br>';
    } else {
        echo '$a = 0  不满足条件 if(empty($a)) <br><br>';
    }

    $a = "0";

    if ($a == "") {
        echo '$a = "0" 满足条件if($a == "") <br>';
    } else {
        echo '$a = "0" 不满足条件if($a == "") <br>';
    }
    
    if ($a === "") {
        echo '$a = "0"  满足条件 if($a === "") <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a === "") <br>';
    }

    if ($a == 0) {
        echo '$a = "0"  满足条件 if($a == 0) <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a == 0) <br>';
    }

    if ($a === 0) {
        echo '$a = "0"  满足条件 if($a === 0) <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a === 0) <br>';
    }

    if ($a == null) {
        echo '$a = "0"  满足条件 if($a == null) <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a == null) <br>';
    }

    if ($a === null) {
        echo '$a = "0"  满足条件 if($a === null) <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a === null) <br>';
    }

    if ($a) {
        echo '$a = "0" 满足条件 if($a) <br>';
    } else {
        echo '$a = "0"  不满足条件 if($a) <br>';
    }

    if (empty($a)) {
        echo '$a = "0" 满足条件 if(empty($a)) <br>';
    } else {
        echo '$a = "0" 不满足条件 if(empty($a)) <br>';
    }

}

test();



/**
 *@description   7.1 version
 * 测试结果：
    $a = 0 满足条件 if($a == "") 
    $a = 0 不满足条件 if($a === "") 
    $a = 0 满足条件 if($a == "0") 
    $a = 0 不满足条件 if($a === "0") 
    $a = 0 满足条件 if($a == null) 
    $a = 0 不满足条件 if($a === null) 
    $a = 0 不满足条件 if($a) 
    $a = 0 满足条件 if(empty($a)) 

    $a = "0" 不满足条件if($a == "") 
    $a = "0" 不满足条件 if($a === "") 
    $a = "0" 满足条件 if($a == 0) 
    $a = "0" 不满足条件 if($a === 0) 
    $a = "0" 不满足条件 if($a == null) 
    $a = "0" 不满足条件 if($a === null) 
    $a = "0" 不满足条件 if($a) 
    $a = "0" 满足条件 if(empty($a)) 
**/

/**
 * @description   5.6 version
 * 测试结果：
    $a = 0 满足条件 if($a == "") 
    $a = 0 不满足条件 if($a === "") 
    $a = 0 满足条件 if($a == "0") 
    $a = 0 不满足条件 if($a === "0") 
    $a = 0 满足条件 if($a == null) 
    $a = 0 不满足条件 if($a === null) 
    $a = 0 不满足条件 if($a) 
    $a = 0 满足条件 if(empty($a)) 

    $a = "0" 不满足条件if($a == "") 
    $a = "0" 不满足条件 if($a === "") 
    $a = "0" 满足条件 if($a == 0) 
    $a = "0" 不满足条件 if($a === 0) 
    $a = "0" 不满足条件 if($a == null) 
    $a = "0" 不满足条件 if($a === null) 
    $a = "0" 不满足条件 if($a) 
    $a = "0" 满足条件 if(empty($a)) 
 */




