<?php
$a = [];
// $a['101'] = 101;
$a[101] = 102;
$a[1] = 1;
$a['102'] = 102;
$a['101'] = null;
var_dump($a);

/**
 * 结果为:
 * array(3) {
  [101] =>
  NULL
  [1] =>
  int(1)
  [102] =>
  int(102)
}
 实际上101 和 '101'被视为同一个键了。不像C语言那样 数字键就必须是数字索引 ，且索引值要在有效范围内
 */