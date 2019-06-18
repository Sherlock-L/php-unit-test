<?php
//https://www.php.net/manual/zh/language.oop5.references.php   官方解释
//在 PHP 5，一个对象变量已经不再保存整个对象的值。只是保存一个标识符来访问真正的对象内容
//https://www.cnblogs.com/taijun/p/4208008.html  一篇博客 关于深拷贝的
class obj {
    public $id;
}

function getNewObj($obj){
        return $obj;
}

function changeId($obj){
        $obj->id = 888;
}

$obj = new obj();
$obj->id = 1;
//obj 、obj_1 将会使用同一个“底层对象”，之所以这样称，主要方便理解，其实这涉及到php zval 的存储结构知识
$obj_1 = $obj;

$obj->id= 3;
var_dump($obj_1);
$obj_1->id = 4;//obj 的id 值也会变，其实本质他们还是使用同一个“底层对象”，所以看起来才会同时改变
var_dump($obj);
$obj_1->name = "obj_1新增属性name";//obj 也会新增对应属性，
var_dump($obj_1);
var_dump($obj);

//三个变量其实使用的还是同一个底层的对象
$a = [];
$a['obj'] = $obj;
var_dump($a);
$obj->id= 5;//其他的变量对应的id 属性也会改变，包括数组a 里的obj 的属性所指的对象值
var_dump($obj_1);
var_dump($obj);
var_dump($a);


$a['obj']->age = "新增年龄属性 age";//同理 obj_1、obj 也会增加相应的age 属性
var_dump($obj_1);
var_dump($obj);
var_dump($a);

//通过函数传递了一个变量，但是在函数内修改对象属性值时，外部变量的属性也被修改了。其实外部内部都是使用同一个对象，这个对象并不是指$obj,$obj_1
//可以理解成他们只是更底层对象的一个别名罢了
changeId($obj);
var_dump($obj_1);
var_dump($obj);
var_dump($a);

// 通过函数return  依然还是使用的原来的对象，只是新增了一个zval 但是这个zval 的zvalue 还是指向原来的对象
$newObj = getNewObj($obj);
$newObj->new = "这是return 后新增的属性";
var_dump($obj);
var_dump($newObj);
var_dump($a);


//如果想深拷贝，可以使用序列化函数
$tmp = serialize($obj);// 序列化，其实就是变成字符串，这个字符串描述了原来对象的结构和值。
//但是本质还是一个简单的数据类型=》字符串

var_dump($tmp);
$obj_2 = unserialize($tmp);//再反序列化转成新的对象
$obj_2->new = "序列化后的new值";
var_dump($obj);
var_dump($obj_2);