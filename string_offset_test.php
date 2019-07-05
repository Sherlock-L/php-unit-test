<?php

$a = "abcdefg";

echo $a{0};
echo $a{1};
echo $a[3];
var_dump(strlen($a));
var_dump($a['sss']); //发出一个警告，返回$a{0} warning
var_dump($a['2']); //和$a[2]一样

var_dump($a['2sad']); //和$a[2]一样  notice