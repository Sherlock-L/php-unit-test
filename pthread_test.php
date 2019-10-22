<?php
//https://www.php.net/manual/zh/book.pthreads.php
//依赖 php要线程安全版本。
class My extends Thread{
    function run(){
        for($i=1;$i<3;$i++){
            echo Thread::getCurrentThreadId() .  "\n";
            sleep(2);     // <------
        }
    }
}

for($i=0;$i<3;$i++){
    $pool[] = new My();
}

foreach($pool as $worker){
    $worker->start();
}
foreach($pool as $worker){
    $worker->join();//让每个worker线程加入到当前的主线程。然后主线程等待所有join的线程执行完后才会继续往下执行，如果不join 可能主线程先结束，子线程继续执行
}
echo "完毕";
?>
