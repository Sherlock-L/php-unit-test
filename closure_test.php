<?php
/**
 * @description  匿名函数使用测试
 */
function test(Closure $function){
    return $function();

}
$params = ['a'=>1,'b'=>2];
test(function () use ($params){
    var_dump($params);
    var_dump($params['a']);
    var_dump($params['b']);
});



/**
 * @description  结论 ：当参数类型是一个Closure 时，要执行 需要在变名后面加上 ();
 */


