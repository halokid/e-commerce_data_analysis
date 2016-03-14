<?php
/**
* Copyright 0x029 Inc. 
* License: MIT License
* Author: JJyy<82049406@qq.com>
* e-commerce data analysis for user 
**/
require_once('./mpp_cls.php');


$mpp = new Mpp("http://127.0.0.1:9090/mpp");
$mpp->setTblPrefix('xx_');
// $str = $mpp->fetch("select * from user limie 1");
// print_r($str);

//after register, the user purchased or not
function isPurchased($userId) {
  global $mpp;
  $sql = "select order_id from ".$mpp->_tblPrefix."order_info where user_id=".
          $userId." and order_status=1 and pay_status=2";
  // echo $sql;
  $arr = $mpp->fetch($sql);
  print_r($arr);
}
isPurchased(1);


//login times after user register
//the DB design not support now,  reconsideration
function loginTimes($userId) {
    
}

//the interval time for every login
//the DB design not support now,  reconsideration
function intervalLogin($userId) {
  
}

/**
* first purchased in the day
*
*@author: JJyy
*@param:  date: '2016-01-10'
*@return: bool 
*
**/
function firstPurchasedInDay($date) {
  global $mpp;
  $startTime = strtotime($date.' 00:00:00');
  $endTime = strtotime($date.' 24:00:00');
  $sql = "select order_id from ".$mpp->_tblPrefix."order_info where 
          confirm_time>".$startTime." and confirm_time<".$endTime." and
          order_status=1 and pay_status=2";
  $arr = $mpp->fetch($sql);
  // print_r($arr);
  if($arr['rows'] == '') {
    return false;
  } else {
    $sqlCheckOld = "select order_id from ".$mpp->_tblPrefix."order_info where 
    confirm_time<".$startTime." and order_status=1 and pay_status=2";
    $arrCheckOld = $mpp->fetch($sqlCheckOld);
    if($arrCheckOld['rows'] != '') {
      return false;
    } else {
      return true;
    }
  }
}
var_dump(firstPurchasedInDay('2015-06-11'));


/**
* has history purchased before the day
*
*@author: JJyy
*@param:  date: '2016-01-10'
*@return: bool 
*
**/
function hasHistoryPurchased($date) {
  global $mpp;
  $startTime = strtotime($date.' 00:00:00');
  $endTime = strtotime($date.' 24:00:00');
  $sql = "select order_id from ".$mpp->_tblPrefix."order_info where 
          confirm_time<".$startTime." and order_status=1 and pay_status=2";
  $arr = $mpp->fetch($sql);
  // print_r($arr);
  if($arr['rows'] == '') {
    return false;
  } else {
    return true;
  }
}
var_dump(hasHistoryPurchased('2015-06-11'));

/**
* check the user join club or not 
*
*@author: JJyy
*@param:  int userId 
*@return: bool 
*
**/
function checkClub($userId) {
  global $mpp;
  $sql = "select club from ".$mpp->_tblPrefix."users where user_id=".$userId;
  $arr = $mpp->fetch($sql);
  if ($arr['rows'][0]['club'] == 0) {
    return false;
  } else {
    return true;
  }
}
var_dump(checkClub(361));

?>

