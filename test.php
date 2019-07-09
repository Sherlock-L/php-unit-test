<?php 

class test{
    public static $id ;

    public  $name ;
    public  $age ;
    public function info (){
            echo self::$id;
    }

    public function __sleep(){
            return ['age'];
    }

    public function __wakeup(){
        $this->age = 110;
    }
}


$a  = new test();
$a->name  = "liushuiwen";
$a->age  = 996;

$b = serialize($a);
echo $b;
$b = unserialize($b);

echo $a->age ;
echo " 序列化 \n " ;
echo $b->age ;

