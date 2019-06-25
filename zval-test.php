<?php
//测试前可查看 http://www.laruence.com/2018/04/08/3170.html 文章，关于php 7 zval 的新的结构
echo "初始: ".memory_get_usage()." 字节 <br>:";//366920 字节 

$array = range(1,99999); 
echo "赋值$array时: ".memory_get_usage()." 字节  <br>";// 直接飙到 4571096 字节
xdebug_debug_zval('array'); // (refcount=1, is_ref=0)
$a  = $array; //共用一个 zval ，其值存在zval结构里 类型标志位为数组 zvalue 联合体中 ， refcount++ ,is_ref不变

echo "赋值a时: ".memory_get_usage()." 字节  <br>";// 4571096 字节
xdebug_debug_zval('a'); //(refcount=2, is_ref=0)
xdebug_debug_zval('array');//(refcount=2, is_ref=0)

function dummy($tmp) { //因为参数不是引用传递，所以原来数组类型的zvalue refcount++
    echo "循环时内存: ".memory_get_usage()." 字节  <br>";//循环时内存: 4571096 字节 
    xdebug_debug_zval('tmp');//因为此函数没有写 ，不会产生分离  所以是(refcount=3, is_ref=0)
}
//执行到这的时候，dummy函数结束后会销毁$tmp，所以 原来那个zvalue  refcount--，   zval 又变为 (refcount=2, is_ref=0)
$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array); 

}
printf("Used %sS <br>", microtime(true) - $start);//Used 0.0010001659393311S   。如果是php 5 会比7慢得多。为什么呢？留个疑问，自己测试。提示：考虑是否发生了value的copy 每次循环重新开辟内存

$b = &$array; //注意这里, 假设我不小心把这个Array引用给了一个变量，此时，$array zval 变成了引用类型 ，和$a分离，$a 单独使用一个zval，而$b和$array使用新的zval
//但是 新的zval 的zvalue是一个引用类型（这是php7新增的数据类型），虽然是不同的zval ，但是新的zval 的zvlaue做为引用类型（可以理解为值存的是一个指针），其实是指向原来zval的zvalue 。
//所以到现在系统中也就存了一份数组的值，保存在老的zval的zvlaue中，测试结果如下 ：
echo "赋值b = &array时: ".memory_get_usage()." 字节  <br>";//赋值 4571392 字节 基本也没有太大变化
xdebug_debug_zval('a'); //(refcount=2, is_ref=0)  refcount=2是因为a的zvalue 被 b和$array的zval 共享了，这也就是某些时候php7比5内存占用小的原因，为什么可以这样做，其实就是zvalue本身也是一个
//联合体，值本身就能计数，可以理解成，php7的zval就是php5的zval 的封装，多包了一层，这样就能更好的通过指针去灵活的共享值了，从而节省内存
xdebug_debug_zval('array');//(refcount=2, is_ref=1) //这里的refcount=2，是 因为$b = &$array ，发生分离，变成了引用类型的zval，$b和$array共同使用引用类型的zval 
xdebug_debug_zval('b');//(refcount=2, is_ref=1) 



$b[] = 1;//由于$b已经是一个引用类型，当发生写的时候，值改变了，意味着不能和原来老的zval 共同使用同一个在value了。看一下结果
echo "修改b时: ".memory_get_usage()." 字节  <br>";//8765760 字节 内存占用 翻了快一倍 可见此处发生了分离。
xdebug_debug_zval('a');//(refcount=1, is_ref=0)  因为 $b改变了值，所以zvalue不在使用$a的zvalue,自然refcount--，变为1
xdebug_debug_zval('array');//(refcount=2, is_ref=1) ，因为$b为引用类型，所以实际和$array是同一个zval，不会发生分离
xdebug_debug_zval('b');//(refcount=2, is_ref=1) 
$c = &$array;//注意 ，此时$array 的zvalue已经是一个引用类型，所以&$array没有改变其的zval ，这里只是refcount++;对于php5 是没有引用类型的在zvaule，需要开辟一个新值，增加额外内存。
echo "赋值c=&array时: ".memory_get_usage()." 字节  <br>";//8765760 字节  几乎没变化
xdebug_debug_zval('a');//(refcount=1, is_ref=0)
xdebug_debug_zval('array');;//(refcount=3, is_ref=1)
xdebug_debug_zval('b');;//(refcount=3, is_ref=1)
xdebug_debug_zval('c');;//(refcount=3, is_ref=1)

$d = $array;//由于$array是引用类型，但是此时的赋值又是非引用型，所以新开辟一个在zval，同时$array、c、b 依然是引用类型的zval，他们的zvalue 的指向发生改变，指向了$d的zvalue。所以结果如下
echo "赋值d=array时: ".memory_get_usage()." 字节  <br>";//8765760 字节   几乎没变化
xdebug_debug_zval('a');//(refcount=1, is_ref=0)
xdebug_debug_zval('array');//(refcount=3, is_ref=1)
xdebug_debug_zval('b');//(refcount=3, is_ref=1)
xdebug_debug_zval('c');//(refcount=3, is_ref=1)  此时的refcount 3  由于 有b 、c 、array三个变量引用
xdebug_debug_zval('d');//(refcount=2, is_ref=0)   refcount=2 意味着当前 b 、c 、array 的公共zvalue 指向 变量d 的zvalue
$i = 0;
$start = microtime(true);
while($i++ < 1) {
    dummy($array);//(refcount=3, is_ref=0)  //此时 dummy函数参数变量实际上使用的是$d 的zval，所以 原来(refcount=2, is_ref=0)  变为了3。虽然传参传的是$array,但是参数是作为值传递，
    //所以最终还是直接使用$d 的zvalue。这样看来 内存确实省了很多，如果这个zvalue 的值很占内存的话.

}

printf("Used %ss <br>", microtime(true) - $start);//Used 0.00099992752075195s 