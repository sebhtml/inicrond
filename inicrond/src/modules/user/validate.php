<?php
//$Id$

//email validation
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if(isset($_GET["register_random_validation"]) AND
$_GET["register_random_validation"] != ""
)
{
        
	$module_title =  $_LANG['email_account_validation'];
        
        
        $query = "SELECT
        usr_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        register_random_validation='".$_GET["register_random_validation"]."'
        AND
        usr_activation=0
        ";
	$rs = $inicrond_db->Execute($query);
        
	$fetch_result = $rs->FetchRow();
	
        
	if(isset($fetch_result['usr_name']))
	{
                
                
                
                $query = "UPDATE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
		SET
		usr_activation=1,
		register_random_validation=NULL
		WHERE
		register_random_validation='".$_GET["register_random_validation"]."'
		AND
		usr_activation=0
		";
                
                
                $inicrond_db->Execute($query);
                
                $module_content .= sprintf($_LANG['hi_ppl_you_can_connect'], $fetch_result['usr_name']);
	}
	else
	{
                $module_content .= $_LANG['invalid_request'];
                
                
	}
	
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php'; 

?>