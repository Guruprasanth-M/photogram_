<?php

include_once 'includes/mic.class.php';
include_once 'includes/database.class.php';
include_once 'includes/user.class.php';
include_once 'includes/session.class.php';
include_once 'includes/UserSession.class.php';
include_once 'includes/WebAPI.class.php';

global $__site__config;
$__site__config = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../photogramconfig.json');


function get_config($key,$default = null){
  global $__site__config;
  $array = json_decode($__site__config, true);
  if (isset($array[$key])){
    return $array[$key];
  }else{
    return $default;
  }
}


$wapi  = new WebAPI();
$wapi->initiateSession();
function load_template($name){
   /*   print("including".__DIR__."/_template/$name.php");
     print(__FILE__);
     print(__LINE__);
     include __DIR__. "/../_template/$name.php";*/
 include $_SERVER['DOCUMENT_ROOT']."/app/_template/$name.php";
}
function validate_credential($username,$password){
  if($username == 'guru@123' and $password == 'password'){
    return true;
} else {
  return false;
}
}

