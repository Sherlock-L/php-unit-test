<?php
//error_reporting(E_ALL);
error_reporting(0);
ob_implicit_flush();
echo "<h2>TCP/IP Connection</h2>\n";

/* Get the port for the WWW service. */
$service_port =10086;// getservbyname('www', 'tcp');

/* Get the IP address for the target host. */
$address = '127.0.0.1';//gethostbyname('www.example.com');

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "socket_create is OK.\n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";

while(true){
    $result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo  "暂时没有连到服务\n";
    sleep(1);
    continue;
  //  echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "连接OK.\n";
    break;
}
}

$in = "HEAD / HTTP/1.1\r\n";
$in .= "Host: www.example.com\r\n";
$in .= "Connection: Close\r\n\r\n";
$in .= "quit\r\n";//让远程关闭与自己的连接，仅仅为了测试，业务不会有这种操作
// $in .= "shutdown\r\n";

$out = '';

echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
echo "OK.\n";

echo "Reading response:\n\n";
while ($out = socket_read($socket, 2048)) {//阻塞的。。。
// while ($out = socket_recv($socket, $buf, 2048, MSG_DONTWAIT)) {
//区别 https://www.jb51.net/article/60920.htm
     echo $out.'';
}

echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";
?>