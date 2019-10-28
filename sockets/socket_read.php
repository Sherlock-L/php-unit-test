<?php
function waitResponse($response = "") {
   $status = "";
   $tries = 3;
   $counter = 0;
   while ($status == $response) {
            $status = socket_read($socket, 1024);
            if(!$status){
               if($counter >= $tries){
                  break;
               }else{
                  $counter++;
                  sleep(3);
               }
            }
   }
return $response;
}