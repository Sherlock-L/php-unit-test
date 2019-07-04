<?php 

 //捕获notice warning 等
function myErrorHandler($errno, $errstr, $errfile, $errline) 
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }
    var_dump($errno);
    var_dump($errstr);
    var_dump($errfile);
    var_dump($errline);

}

//捕获未捕获的异常
function exception_handler($exception) {
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
  }
  
  set_exception_handler('exception_handler'); //https://www.php.net/manual/zh/function.set-exception-handler.php 注册捕获未捕获的异常
  set_error_handler("myErrorHandler");  //https://www.php.net/manual/zh/function.set-error-handler.php   本函数可以用你自己定义的方式来处理运行中的错误，捕获notice
 
class a{
    public function test(){
        try {
            echo $test;
            // print_r(error_get_last()); 获取最后的notice 信息
            // $error = 'Always throw this error';
        
            //     throw new Exception($error);
    
        } catch (Exception $e) {
            $logInfo = "{$e->getMessage()} code-line:{$e->getLine()} code-file:{$e->getFile()}";
            echo $logInfo;
        }
    }
}

$a = new a();
$a->test();
throw new Exception("手动抛出异常调用默认注册的异常处理函数");

