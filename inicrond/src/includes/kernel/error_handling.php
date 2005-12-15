<?php

//error_reporting(E_ALL & ~E_NOTICE);

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
	$errors[E_ERROR] = "E_ERROR";
	$errors[E_WARNING] = "E_WARNING";
	$errors[E_PARSE] = "E_PARSE";
	$errors[E_NOTICE] = "E_NOTICE";
	$errors[E_CORE_ERROR] = "E_CORE_ERROR";
	$errors[E_CORE_WARNING] = "E_CORE_WARNING";
	$errors[E_COMPILE_ERROR] = "E_COMPILE_ERROR";
	$errors[E_COMPILE_WARNING] = "E_COMPILE_WARNING";
	$errors[E_USER_WARNING] = "E_USER_WARNING";
	$errors[E_USER_ERROR] = "E_USER_ERROR";
	$errors[E_USER_NOTICE] = "E_USER_NOTICE";   
	$errors[E_ALL] = "E_ALL";
	//$errors[E_STRICT] = "E_STRICT";
	
	echo "
	Error type : ".$errors[$errno]."<br />
	Error # : $errno<br />
	Error msg : $errmsg<br />
	File : $filename<br />
	Line $linenum<br />
	Variables : $vars<br />
	<hr />";
}

$old_error_handler = set_error_handler("userErrorHandler");

?>