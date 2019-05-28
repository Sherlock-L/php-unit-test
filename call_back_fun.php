<?php

class Test {

  public static function  a(){
      echo "this is  public a() ";
  }

  public  function  b($p1,$p2){
    echo "this is  public b()  \$p1+\$p2=".($p1+$p2);
}


  private  function  c($p1,$p2){
    echo "this is private c() \$p1+\$p2=".($p1+$p2);
    }

    protected  function  d($p1,$p2){
        echo "\n this is private d()  \$p1+\$p2=".($p1+$p2);
    }
    
}

function outside($param = "默认值"){
  echo " \n 这是一个外部函数  \$param =".$param;
}
{
    # code...
}

//调用外部方法的测试

if(is_callable('xxxx')){//结果为false
    echo "存在方法xxxx() \n";
}else{
    echo "不存在方法xxxx() \n";
}

if(is_callable('outside')){//结果为true
    echo "存在方法outside() \n";
}else{
    echo "不存在方法outside() \n";
}

echo "call_user_func('outside')执行结果:";
call_user_func('outside');

echo "\ncall_user_func('outside','德玛西亚')执行结果:";
call_user_func('outside','德玛西亚');

echo " \n";
//调用对象内的方法
$test = new Test();
$tmp = [$test,'b'];//如果写成 [test,'b'] php 7.1发出一个notice 会先以为test 为常量，如果未找到会在当前符号表读test 的变量。。够强
if(is_callable($tmp)){//结果为true 
    echo "public b() 可访问\n";
}else{
    echo "public b() 不可访问 \n";
}

$tmp = [$test,'c'];
if(is_callable($tmp)){//结果为false 因为c()属于private 不可见函数
    echo "private c() 可访问\n";
}else{
    echo "private c() 不可访问 \n";
}

//不带参数写法
$tmp = [$test,'a'];
call_user_func($tmp);
echo " \n";
//带参数写法,$第一个参数tmp为一个数组，存放对象和对应的方法名，后面根据方法的要求，填写对应数量的参数
$tmp = [$test,'b'];
$p1= 2;
$p2 = 3;
call_user_func($tmp,0,4);
