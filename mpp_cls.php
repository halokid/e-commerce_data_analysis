<?php 
/**
* Copyright 0x029 Inc. 
* License: MIT License
* Author: JJyy<82049406@qq.com>
* Mpp client PHP class 
**/

class Mpp {
  public $_mppServ;
  public $_tblPrefix;
  protected static $_uukey = "9f89c3e4bee30185648172d9013525cf";
  
  function __construct($mppServ) {
    $this->_mppServ = $mppServ;
    // echo $this->_mppServ;
  }
  
  function setTblPrefix($prefix) {
    $this->_tblPrefix = $prefix;
  }
  
  function fetch($query) {
    // echo $this->_mppServ;
    $cl = curl_init();
    // curl_setopt($cl, CURLOPT_URL, "http://127.0.0.1:9090/mpp");
    curl_setopt($cl, CURLOPT_URL, $this->_mppServ);
    // curl_setopt($cl,CURLOPT_POSTFIELDS,'uukey='.self::$_uukey.'&query=select email from '.$this->_tblPrefix.'users order by id'); 
    curl_setopt($cl,CURLOPT_POSTFIELDS,'uukey='.self::$_uukey.'&query='.$query); 
    curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
    $str = curl_exec($cl);
    // echo $str;
    $jsonArr = json_decode($str, true);
    return $jsonArr;
    curl_close($cl);  
  }
  
}

/**
$mpp = new Mpp("http://127.0.0.1:9090/mpp");
$str = $mpp->fetch("select * from user limie 1");
print_r($str);
**/
?>
