<?php

/**
 * @description ####### php  mysql  模糊匹配存放着多维数组（含中文）转成的json字符串 #####
 */


//数据库base_maintain_company 表里maintain_contacts字段 存放着json 数据，此时我需要前端通过传关键字来模糊匹配maintain_contacts字段记录，如图
/*
  select maintain_com_id,maintain_com_name,maintain_contacts from base_maintain_company  where maintain_com_id = 68;

+-----------------+-------------------+-----------------------------------------
--------------------------------------------------------------------------------
------------------------------+
| maintain_com_id | maintain_com_name | maintain_contacts

|              68 | 水电费公司        | [{"name":"\u8ba1\u7b97\u673a","tel":"123
45687112"},{"name":"\u80c3\u80a0\u5b89","tel":"2334121111"},{"name":"\u5927\u4e0
9\u623f","tel":"1223121211"}] |
+-----------------+-------------------+-----------------------------------------
--------------------------------------------------------------------------------
------------------------------+
1 row in set (0.00 sec)
 * */
//mysql 本身支持json的查询操作，参考链接https://www.cnblogs.com/ooo0/p/9309277.html。但是，貌似多维的json匹配就匹配不到了。
//所以将计就计，把maintain_contacts当成一个字符串，然后用like 匹配。刚开始试的时候一直不成功
//发现的问题：中文json格式化后 过后变成了16进制的数据，同时存入数据库时带有反斜杠（\），虽然打印下来如图，只有1条，但是实际需要4条反斜杠来描述
//###有这么个解释 因为反斜线符号会被语法分析程序剥离一次，在进行模式匹配时，又会被剥离一次。反过来在自动增加反斜杠转义时，原来一条反斜杠会翻倍两次，就变了4条###。
//解决办法;故需要在like之前,将匹配的字符传也json 格式化。然后再拼接   like "%$you_string%"


$matchName = '计算机';
//mysql  \  变为  \\\\
$likeName =json_encode($matchName);
//json 一个字符串后，会收尾带有一个双引号，数组就没有这个状况 去除前后的双引号,
$likeName = substr($likeName, 1);
$likeName = substr($likeName, 0, -1);
$likeName = str_replace('\\','\\\\\\\\',$likeName);
// $likeName = str_replace('\\','\\\\',$likeName); 如果是使用框架，或者本身默认开启addslashes(),转义方法，就少一半替换，因为addslashes() 会基于当前再转义一遍
$sql = "select maintain_com_id,maintain_com_name,maintain_contacts from base_maintain_company  where maintain_contacts like'%name\":\"{$likeName}%'";
echo "likeName:\n";
print_r($likeName) ;
echo "\n";
echo "sql:\n";
print_r($sql) ;

//打印结果 ,
/*
likeName:
\\\\u8ba1\\\\u7b97\\\\u673a
sql:
select maintain_com_id,maintain_com_name,maintain_contacts from base_maintain_company  where maintain_contacts like'%name":"\\\\u8ba1\\\\u7b97\\\\u673a%'

 */