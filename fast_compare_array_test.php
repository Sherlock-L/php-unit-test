<?php
/**
 * @description ### php 快速对比两个数组结果 ###
 */


//目前的例子是只按照键值匹配，使用的是一维数据
//场景： 加入  有一个$oldIdList,前端增删、修改后，前端传来新的数据变量$newIdList 。我需要找出与原来数据相比，哪些是新增的，哪些是删除的
//以便于在后续的数据库curd 操作时，做insert 或者 delete 操作
//步骤  1 array_intersect 取交集  2.array_diff 取差集
//##如果想按照键名或者 其他自定义的比较函数，可以参考对应函数：链接地址 http://www.w3school.com.cn/php/php_ref_array.asp##

//修改前
$oldIdList = [1, 2, 3];
//前端传入后
$newIdList = [2, 3, 4];

//交集
$public = array_intersect($oldIdList, $newIdList);
echo "public:\n";
var_dump($public);
/*测试结果如下：
public:
array (size=2)
 1 => int 2
 2 => int 3
*/
//用交集与老数据对比，得到需要delete 的部分,注意两个参数的放置顺序
$needDelete = array_diff($oldIdList, $public);
//用交集与新数据对比，得到需要insert 部分，注意两个参数的放置顺序
$needInsert = array_diff($newIdList, $public);

echo "needDelete:\n";
var_dump($needDelete);
echo "needInsert:\n";
var_dump($needInsert);

/*得到如下结果：
needDelete:
array (size=1)
  0 => int 1
needInsert:
array (size=1)
  2 => int 4
*/

//注意  array_diff是按照值匹配的，是以第一个参数为基准，如果第一个参数为空数组，那么返回空数组。如果不为空。那么返回的内容也是在第一个参数范围内的。
//以下又做了两组对比测试
$test1 = array_diff([], [1, 3, 4]);
echo "test1:\n";
var_dump($test1);

$test2 = array_diff([7, 8, 9], [7, 1, 3, 4]);
echo "test2:\n";
var_dump($test2);

$test3 = array_diff([7, 8, 9], []);
echo "test3:\n";
var_dump($test3);

/* 测试结果如下
array (size=0)
  empty
test2:
array (size=2)
  1 => int 8
  2 => int 9
test3:
array (size=3)
  0 => int 7
  1 => int 8
  2 => int 9
 * */