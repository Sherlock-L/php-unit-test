<?php

/*
https://www.php.net/manual/zh/sockets.examples.php  范例
https://www.php.net/manual/zh/sockets.errors.php  错误捕获

*/ 
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in.
 * 将打开或关闭绝对（隐式）刷送。绝对（隐式）
 * 刷送将导致在每次输出调用后有一次刷送操作，以便不再需要对 flush() 的显式调用。
 * https://www.php.net/manual/zh/function.ob-implicit-flush.php */
ob_implicit_flush();

$address = '127.0.0.1';
$port = 10086;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}
echo '等待客户端连接'. "\n";
do {
    if (($msgsock = socket_accept($sock)) === false) {//这里是阻塞的。。。知道连到一台为止
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    echo '已连接到一个客户端，并返回给客户端一个welcome欢迎词'. "\n";
    /* Send instructions. */
    $msg = "\nWelcome to the PHP Test Server. \n" .
        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
    socket_write($msgsock, $msg, strlen($msg));
  
    do {
        echo "\n等待客户端的内容...\n";
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {//阻塞的。。。
            //在程序中用socket_last_error()来捕获错误代码。 你可以调用socket_strerror()函数通过错误代码获取错误描述
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        echo "客户端发过来的内容：$buf\n";
        if (!$buf = trim($buf)) {
            echo "内容为空串，不回答客户端... \n";
            continue;
        }
        if ($buf == 'quit') {
            echo "客户端手动断开了连接...\n";
            break;
        }
        if ($buf == 'shutdown') {//客户端输了shutdown ，然后跳出两层循环。把服务端都关了，理论不应该有这种业务操作，仅仅为了测试
            socket_close($msgsock);
            break 2;
        }
        $talkback = "service:i am accept that You said '$buf'.\n";
        echo '回答客户端内容：'.$talkback;
        socket_write($msgsock, $talkback, strlen($talkback));
      
    } while (true);
    socket_close($msgsock);
} while (true);
echo 'service端关闭...'."\n";
socket_close($sock);
?>