<?php

class a {
    public $id;
    public $name;
    private $age;

    public function __set($key,$value){
            echo " $key:$value ";
    }

    public function __get($key){
        echo " $key ";
}

    public function test(){
        // eval('$act=$this->id;');
        if(isset($this->id)){
            echo 'isset($this->id) 为true ';
        }else{
            echo 'isset($this->id) 为 false ';
        }
    }

    public function testProperty(){
        
        if(property_exists($this,'name')){
            echo 'property_exists($this,\'name \') 为true ';
        }else{
            echo 'property_exists($this,\'name \') 为false ';
        }
    }
}

$v = new  a();
$tmp = $v->xxx; //访问为定义的属性；触发__get
//直接访问私有变量 触发 __set();其实设置private 好处就是利用这样的触发机制，在变量的读取之前可以做类似于监听触发其他事件等操作
   //而直接定义成pubic 是无法做到的，
$v->age=66;
   
if(isset($v->id)){
    echo 'isset($v->id) 为true '; //这里虽然id 为class a 的属性 ，但是$v->id 变量并未生成，结果为false，
    //也就是说我们往常如果
}else{
    echo 'isset($v->id) 为 false ';
}

$v->test();//这里$this->id 变量并未生成
echo '$v->id = 666; 后 ';
$v->id = 666;
$v->test(); //这里$this->id 定义了

$v->testProperty();
echo '$v->name = 666; 后 ';
$v->testProperty();
