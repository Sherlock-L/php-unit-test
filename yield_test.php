<?php 

//https://www.php.net/manual/zh/language.generators.syntax.php
//https://www.php.net/manual/zh/generator.send.php 生成器send 方法 很重要！！
// yield：它最简单的调用形式看起来像一个return申明，不同之处在于普通return会返回值并终止函数的执行，
// 而yield会返回一个值给循环调用此生成器的代码并且只是暂停执行生成器函数。
/**
 * yield这个关键字就是用来产生中断, 并保存当前的上下文的, 
 * 比如说程序的一段代码是访问远程服务器，那这个时候CPU就是空闲的，就用yield让出CPU，接着执行下一段的代码，
 * 如果下一段代码还是访问
 * 除CPU以外的其它资源，还可以调用yield让出CPU. 继续往下执行，这样就可以用同步的方式写异步的代码了
 */
function gen_one_to_three() {
    for ($i = 1; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的。
        yield $i;
        /**这样的好处：
         * 1.当这个一个i占用很大的内存或者耗时的时候，就不适合一次性执行完后，返回所有的i的集合
         * ，虽然也可以在生成i后掉一个xx（）函数，但是就耦合了，假设gen_one_to_three很多地方
         * 调用它的返回值，但是业务逻辑不一样，如果写在循环里处理代码就耦合了
         * 2.当进程需要请求网络资源时，由于暂时不需要cpu，可以yield 暂时释放cpu，让其他进程再执行
         * **/
         

    }
}

$generator = gen_one_to_three();
foreach ($generator as $k =>$value) {
     echo "$value\n";//以上例程会输出：1 2 3
}

//和之前生成简单值类型一样，在一个表达式上下文中生成键值对也需要使用圆括号进行包围：
//$data = (yield $key => $value);这样在调用方foreach会返回key value 。
//也可以返回一个的引用变量如  &gen_reference(){}

  //  以下例程会输出：1 2 3 4 5 6 7 8 9 10
function count_to_ten() {
        yield 1;
        yield 2;
        yield from [3, 4];
        yield from new ArrayIterator([5, 6]);
        yield from seven_eight();
        yield 9;
        yield 10;
    }
    
    function seven_eight() {
        yield 7;
        yield from eight();
    }
    
    function eight() {
        yield 8;
    }
    
    foreach (count_to_ten() as $num) {
        echo "$num ";
    }
//用 Generator::send() 向生成器函数中传值,发送send方法意味着发送方暂停 ，然后接收方程序执行之前暂定的点。
//直到接收函数yield 一个值或者执行结束，然后继续执行send方暂停的地方，这就模拟了一个协程.协程保存了各个地方的上下文

    function printer() {
      
        while (true) {//如果不用循环，意味着只接收一次，函数执行完就结束了。
            $string = yield;
            echo $string;
        }
    }
    
    $printer = printer();
    $printer->send('Hello world!');//Hello world! send
    echo $string;


    //通过send方法，再跳到原来暂停处继续执行
    function nums() {
        for ($i = 0; $i < 5; ++$i) {
                    //get a value from the caller
            $a = (yield $i);
          
            if($a == 'stop')
            {
                echo "exit\n";
                return;//exit the function
            }
            }    
    }
    
    $gen = nums();
    // $gen->send('stop');
    foreach($gen as $v)
    {
        if($v == 3)//we are satisfied
           {$gen->send('stop');}
        echo "{$v}\n";
    }
?>

