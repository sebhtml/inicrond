<?php

//error_reporting(E_ALL & ~E_NOTICE);

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
global $_RUN_TIME;

    $errors[1] = "E_ERROR";
  $errors[2] = "E_WARNING";
   $errors[4] = "E_PARSE";
    $errors[8] = "E_NOTICE";
     $errors[16] = "E_CORE_ERROR";
  $errors[32] = "E_CORE_WARNING";
   $errors[64] = "E_COMPILE_ERROR";
$errors[128] = "E_COMPILE_WARNING";
    $errors[256] = "E_USER_WARNING";
     $errors[512] = "E_USER_ERROR";
      $errors[1024] = "E_USER_NOTICE";   
       $errors[2047] = "E_ALL";
   $errors[2048] = "E_STRICT";

 
   
   if($errno != 2048//E_STRICT
    AND $errno != 8//E_NOTICE
    )
   {

echo "
Error type : ".$errors[$errno]."<br />
Error # : $errno<br />
Error msg : $errmsg<br />
File : $filename<br />
Line $linenum<br />
Variables : $vars<br />
<hr />";


/*
 error_log($err, 3, __INICROND_INCLUDE_PATH__."php_errors/".date("Y-m-d_H:i:s_(T)").md5(rand(0, 1000)).".log");
   */   
   
       }

}

$old_error_handler = set_error_handler("userErrorHandler");

?>