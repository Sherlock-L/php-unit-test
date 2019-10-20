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
    $worker->join();
}
?>
