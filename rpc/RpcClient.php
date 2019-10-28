<?php
 /**
 * https://www.php.net/manual/zh/function.stream-socket-server.php
 * */ 
class RpcClient {
    protected $urlInfo = array();
     
    public function __construct($url) {
        //解析URL
        $this->urlInfo = parse_url($url);
      
        if(!$this->urlInfo) {
            exit("{$url} error \n");
        }
    }
     
    public function __call($method, $params) {
        //创建一个客户端
        $client = stream_socket_client("tcp://{$this->urlInfo['host']}:{$this->urlInfo['port']}", $errno, $errstr);
        if (!$client) {
            exit("{$errno} : {$errstr} \n");
        }
        //传递调用的类名
        $class = basename($this->urlInfo['path']);
        $proto = "Rpc-Class: {$class};" . PHP_EOL;
        //传递调用的方法名
        $proto .= "Rpc-Method: {$method};" . PHP_EOL;
        //传递方法的参数
        $params = json_encode($params);
        $proto .= "Rpc-Params: {$params};" . PHP_EOL;
        //向服务端发送我们自定义的协议数据
        fwrite($client, $proto);
        //读取服务端传来的数据
        $data = '';
        $n=1;
        //此处read其实应该封装，比如一次数据量很大，服务端很久才返回，或者设置超时自动断开或者其他处理
        $tmp = fread($client, 2048);
        while(!empty($tmp)){
            $data.= $tmp;
            $tmp=fread($client, 2048);
            $n++;
            echo '第'. $n.'次$tmp='.$tmp."\n";
        }
        //关闭客户端
        fclose($client);
        return $data;
    }
}
 
$cli = new RpcClient('http://127.0.0.1:8888/Test');
echo $cli->sayHello()." \n";
echo $cli->repeat(array('name' => 'Test', 'age' => 27))." \n";