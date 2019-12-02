<?php
namespace App\Http;

use Illuminate\Http\Request as BaseRequest;

class Request 
{
  public $params;
public function __construct (){
 $this->params = BaseRequest::createFromGlobals();
}



}