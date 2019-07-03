<?php
//官网 文档 https://www.php.net/manual/zh/book.pdo.php
/*

PDO — PDO 类
PDO::beginTransaction — 启动一个事务
PDO::commit — 提交一个事务
PDO::__construct — 创建一个表示数据库连接的 PDO 实例
PDO::errorCode — 获取跟数据库句柄上一次操作相关的 SQLSTATE
PDO::errorInfo — Fetch extended error information associated with the last operation on the database handle
PDO::exec — 执行一条 SQL 语句，并返回受影响的行数
PDO::getAttribute — 取回一个数据库连接的属性
PDO::getAvailableDrivers — 返回一个可用驱动的数组
PDO::inTransaction — 检查是否在一个事务内
PDO::lastInsertId — 返回最后插入行的ID或序列值
PDO::prepare — 准备要执行的语句，并返回语句对象 => PDOStatement
PDO::query — 执行 SQL 语句，以 PDOStatement 对象形式返回结果集
PDO::quote — 为 SQL 查询里的字符串添加引号
PDO::rollBack — 回滚一个事务
PDO::setAttribute — 设置属性

PDOStatement — PDOStatement 类
PDOStatement::bindColumn — 绑定一列到一个 PHP 变量
PDOStatement::bindParam — 绑定一个参数到指定的变量名
PDOStatement::bindValue — 把一个值绑定到一个参数
PDOStatement::closeCursor — 关闭游标，使语句能再次被执行。
PDOStatement::columnCount — 返回结果集中的列数
PDOStatement::debugDumpParams — 打印一条 SQL 预处理命令
PDOStatement::errorCode — 获取跟上一次语句句柄操作相关的 SQLSTATE
PDOStatement::errorInfo — 获取跟上一次语句句柄操作相关的扩展错误信息
PDOStatement::execute — 执行一条预处理语句
PDOStatement::fetch — 从结果集中获取下一行
PDOStatement::fetchAll — 返回一个包含结果集中所有行的数组
PDOStatement::fetchColumn — 从结果集中的下一行返回单独的一列。
PDOStatement::fetchObject — 获取下一行并作为一个对象返回。
PDOStatement::getAttribute — 检索一个语句属性
PDOStatement::getColumnMeta — 返回结果集中一列的元数据
PDOStatement::nextRowset — 在一个多行集语句句柄中推进到下一个行集
PDOStatement::rowCount — 返回受上一个 SQL 语句影响的行数
PDOStatement::setAttribute — 设置一个语句属性
PDOStatement::setFetchMode — 为语句设置默认的获取模式。

*/
$dbh = new PDO('mysql:host=localhost;dbname=base_sd', "root");
 
//简单一个查询测试
$query = 'select * from base_user limit 2';
$statement = $dbh->prepare($query);//准备要执行的语句，并返回语句对象
$statement->execute();
//多条打印
print_r($statement->fetchAll());//获取所有结果，数组的形式
print_r($statement->rowCount());//返回行数


//==============非预处理===================  
  
//update  
$affected_rows = $db->exec("UPDATE baser_sd SET userrname='test' where id = 0"); //返回受影响的行数

//insert
$result = $db->exec("INSERT INTO baser_sd(id, userrname) VAULES(0, 'test')");//返回
$insertId = $db->lastInsertId();

//select
$statement = $db->query('SELECT * FROM base_sd'); // 执行 SQL 语句，以 PDOStatement 对象形式返回结果集
while($row = $statement->fetch(PDO::FETCH_ASSOC)) { //从结果集中获取下一行 同时使用数组的形式
        echo $row['id'];
    }
//delete 
$affected_rows = $db->exec("delete from baser_sd  where id = 0");

//======================预处理 ==========================

$calories = 150;
$colour = 'red';
$sth = $dbh->prepare('SELECT name, colour, calories
    FROM fruit
    WHERE calories < :calories AND colour = :colour');
 //通过加 ':'符号作为占位符，然后bindParam 绑定对应的值，注意bindparam 用的是参数传递的是引用，bindValue 才是copy值
$sth->bindParam(':calories', $calories, PDO::PARAM_INT);
$sth->bindParam(':colour', $colour, PDO::PARAM_STR, 12);
$sth->execute();

$sth = $sth->fetchAll(PDO::FETCH_CLASS, "fruit");//每行结果实例化一个类



$sth = $sth->fetchAll(PDO::FETCH_ASSOC);//默认返回的是二维数组结果
var_dump($result);