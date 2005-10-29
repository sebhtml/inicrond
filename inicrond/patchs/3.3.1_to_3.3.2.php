<?php
//$Id$

/*
put this file in the inicrond root installation.
THe root is in fact the src.
*/

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";


$sql = "INSERT INTO 
 ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['sebhtml_options']." (

(opt_name, opt_value) VALUES ('html_output_on_one_line', '1')
";

$inicrond_db->Execute($sql);


?>