 <?php 
//https://www.php.net/manual/zh/function.iconv.php   iconv 函数
//https://php.net/manual/zh/function.mb-convert-encoding.php
$text = "This is the Euro symbol '€'.";

echo 'Original : ', $text, PHP_EOL;
echo 'TRANSLIT : ', iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text), PHP_EOL;//不能转化找一个近似值代替
echo 'IGNORE   : ', iconv("UTF-8", "ISO-8859-1//IGNORE", $text), PHP_EOL;//不能转化的则丢弃
echo 'Plain    : ', iconv("UTF-8", "ISO-8859-1", $text), PHP_EOL;//返回false
echo 'Plain    : ', iconv("UTF-8", "ASC", $text), PHP_EOL;//返回false

$str = 'A';
echo 'ord    : ',  ord($str), PHP_EOL;//输出65   转为ascall 
$asc = '65'; 
echo 'chr    : ',  chr($asc), PHP_EOL; //输出A   ascall转为字符
echo 'mb_convert_encoding    : ',  mb_convert_encoding($text,'UTF-8','GB2312'), PHP_EOL;//  This is the Euro symbol '??.
echo 'mb_convert_encoding    : ',  mb_convert_encoding($text,'GB2312-8','UTF-8'), PHP_EOL;//返回false
echo 'mb_convert_encoding    : ',  mb_convert_encoding($text,'ISO-8859-1','UTF-8'), PHP_EOL;//This is the Euro symbol '?'.