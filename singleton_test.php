<?php
//https://php.net/manual/zh/language.operators.type.php   instanceof 于确定一个 PHP 变量是否属于某一类 class 的实例
//序列化、反序列化 https://www.php.net/manual/zh/function.serialize.php
//clone  https://www.php.net/manual/zh/language.oop5.cloning.php 

/**总结 如果要在做到严格的单例，应该确保不允许外部直接实例化，禁止克隆，禁止序列化；
 * 另外序列化无法 保存存放在静态变量，自然如果静态变量存放着一个实例，要妥善处理
 * 如果想通过多个线程或者 分布式共享一个单例，那就变得更复杂了，也许你可以借助redis 、数据库等手段去管理单例，这里就不做延伸了。
 */

class single { 

    private static $instance;

    private $a ;

    //设为 私有 禁止外部使用new 生成一个新的single 类型的对象
    private function __construct()
    {
        $this->a = '刘水文';
    }

    public function setA($v){
        $this->a = $v;
    }
 
    /**
     * 防止clone 多个实列 ,为了保持单例 ，那么应该阻止其被克隆
     */
    // private function __clone(){}
   

    //测试用方法
    public function info(){
    echo "this->a : $this->a \n"; 
   }
 
     /**
     * 反序列化之前处理 一些属性 ，为了保持单例 应该设为 private  确保当反序列化的时候，让其发出警告
     *  更好的方法应该是在此方法里直接抛出异常，禁止序列化
     */
      private function __wakeup(){
          
      }
  

    /**
     * 序列化 之前调用处理 一些属性  ，为了保持单例 应该设为 private  确保当序列化的时候，让其发生警告
     * 更好的方法应该是在此方法里直接抛出异常，禁止序列化
     *  ***/
    public function __sleep()
    {
        throw new \Exception("禁止单例序列化");
        //__sleep方法必须返回一个数组,包含需要串行化的属性. PHP会抛弃其它属性的值. 如果没有__sleep方法,PHP将保存所有属性.
    }
   

   public static  function getInstance(){
      if(self::$instance===null){
        self::$instance = new self();
      }
      return  self::$instance ;
   }
}

$a  = single::getInstance();
$b =  single::getInstance();

var_dump($b); //a 、 b 使用同一个对象
var_dump($a);

$c = clone $a; //破坏了单例原则，生成了新的实例 。如果将__clone 设为私有方法，将会发生fatal error  ，设为私有意味不能克隆，保护单例
var_dump($c);

$a->setA("赵四"); 
echo "c->info():  \n";
$c->info();
echo "c->getInstance()->info():  \n";
$c->getInstance()->info(); //输出$c->getInstance()  其实还是指的原来的$a 所指的对象，因为$c->getInstance() 返回的是一个静态变量

xdebug_debug_zval('a'); // (refcount=3, is_ref=0)=class single { private $a = (refcount=2, is_ref=0)='赵四' }
xdebug_debug_zval('b');//(refcount=3  因为   self::$instance 静态变量也指向了同一个实例
xdebug_debug_zval('c');//破坏了单例原则， c 是新的对象 和a、b 完全没关系,只不过  静态变量  $instance 依然和 a、b 所指的是同一对象

$d  = serialize($c);//序列化
$d   = unserialize($d);
var_dump($a);
var_dump($d);//序列化后 也new 了一个新的对象
echo "d 反序列化后";
echo " d->info():  \n";
$d->info();//此时输出新对象 的属性值
echo "d->getInstance()->info():  \n";
$d->getInstance()->info();//getInstance() 依然返回了 原来的对象，因为没有被销毁




xdebug_debug_zval('a'); //(refcount=3, is_ref=0)=class single { private $a = (refcount=2, is_ref=0)='a当爸爸' } 
xdebug_debug_zval('b');//(refcount=3  因为   self::$instance 静态变量也指向了同一个实例
xdebug_debug_zval('c');// (refcount=1, is_ref=0)=class single { private $a = (refcount=2, is_ref=0)='niubi' }
xdebug_debug_zval('d');// (refcount=1, is_ref=0)=class single { private $a = (refcount=2, is_ref=0)='niubi' }

