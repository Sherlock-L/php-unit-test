<?php
$st="Message to sent";
$length = strlen($st);
       
    while (true) {
       
        $sent = socket_write($socket, $st, $length);
           
        if ($sent === false) {
       
            break;
        }
           
        // 检查是否所有内容都发送过去了
        if ($sent < $length) {
               
            // If not sent the entire message.
            // Get the part of the message that has not yet been sented as message
            $st = substr($st, $sent);
               
            // Get the length of the not sented part
            $length -= $sent;

        } else {
           
            break;
        }
           
    }
?>