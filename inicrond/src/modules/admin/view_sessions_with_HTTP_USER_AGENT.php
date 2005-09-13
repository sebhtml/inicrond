<?php

//$Id$

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if($_SESSION['SUID'])
{
        
        $module_content .= "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
	if(!isset($_POST['HTTP_USER_AGENT']))
	{
                $module_title =  $_LANG['view_sess_with_http_user'];
                
                $module_content .=  "<form method=\"POST\">
                
                ".  $_LANG['HTTP_USER_AGENT']." <input type=\"text\" name=\"HTTP_USER_AGENT\"  />
                
                <input type=\"submit\" name=\"soumission\"  value=\"".$_LANG['txtBoutonForms_ok']."\" />	 
                </form>" ;
	}
	else
	{
                
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                js_redir(__INICROND_INCLUDE_PATH__."modules/seSSi/sessions_img.php?&HTTP_USER_AGENT=".$_POST['HTTP_USER_AGENT']);
	}
        
}



include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>