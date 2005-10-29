<?php
//$Id$

/*---------------------------------------------------------------------
sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-----------------------------------------------------------------------*/

if(!__INICROND_INCLUDED__){exit();}



$smarty->assign('app_link', "<a href=\"".APPLICATION_DEVEL_WEB_SITE."\" target=\"_blank\">".APPLICATION_COMPLETE_RELEASE_NAME."</a>");

              $smarty->assign("_LANG", $_LANG);
	      $smarty->assign('module_title', $module_title);
       $smarty->assign("module_content", $module_content);

      $smarty->assign('title', $_OPTIONS['titre']);
      
 //   print_R($_SESSION);
      
    if(isset($_GET["print"]) AND
    is_teacher_of_at_least_one_course($_SESSION['usr_id'])
    //can_usr_act_like_that($_SESSION['usr_id'], "MOD_USR_CAN_PRINT_SOMETHING", __FILE__, __LINE__)
    )
    {
       

    $smarty->template_dir = __INICROND_INCLUDE_PATH__."/".'templates/';
   
    if($_OPTIONS['save_page_view'])//save page view.
    {
include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
	 }
	 
$smarty->display($_OPTIONS['theme']."/print.tpl");
    exit();
    }
    else
    {
	if($_OPTIONS['save_page_view'])//save page view.
	{
		include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
	}
    
    }
    
    
  if( is_teacher_of_at_least_one_course($_SESSION['usr_id']))
      {
      $smarty->assign("print_link", "<a href=\"?".$_SERVER['QUERY_STRING']."&print\" target=\"_blank\">".$_LANG['printable_format']."</a>");
      }
      
          $smarty->assign('footer', $_OPTIONS['footer']);   
  $smarty->assign('header', BBcode_parser($_OPTIONS['header']));   
       

   
if($_OPTIONS['debug_mode'] AND
$_SESSION['SUID']
)
{
	include __INICROND_INCLUDE_PATH__."includes/kernel/debug_mod.php";
	
$smarty->assign('debug_mod_content', $debug_mod_content);	 
}

 if(isset($extra_css))
	{
	$smarty->assign('extra_css', $extra_css);
	}
	
 if(isset($extra_js))
	{
	$smarty->assign('extra_js', $extra_js);
	}
	

$smarty->assign('_LANG', $_LANG);
//$smarty->assign('where_are_you', $where_are_you);

/////////////////


	
if(isset($_SESSION['usr_id']))
	{
	$smarty->assign('usr_cp',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$_SESSION['usr_id'], $_LANG['usr_cp']));

	$smarty->assign('log_out',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/log_out.php", $_LANG['log_out']));

//echo $_SESSION['language'];


$smarty->assign('edit_user',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/edit_user.php?usr_id=".$_SESSION['usr_id']."", $_LANG['edit_user']));

$smarty->assign('change_password',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/change_password.php?usr_id=".$_SESSION['usr_id']."", $_LANG['change_password']));


$smarty->assign('my_groups',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/my_groups.php?usr_id=".$_SESSION['usr_id']."", $_LANG['my_groups']));

//cours
$smarty->assign('courses',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/courses/courses.php", $_LANG['courses']));	
	
	}
	else
	{

$smarty->assign('connect',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/connect.php", $_LANG['connect']));
//connection


$smarty->assign('register',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/register.php", $_LANG['register']));
//inscription


$smarty->assign('forgot_password',  retournerHref("".__INICROND_INCLUDE_PATH__."modules/user/forgot_password.php", $_LANG['forgot_password']));
//mot de passe oublié




}









if($_SESSION['SUID'])
	{
$smarty->assign('admin_menu',  retournerHref("../../modules/admin/admin_menu.php", $_LANG['admin_menu']));	
}	
	/*
	foreach($_OPTIONS['languages'] AS  $value)
	{
	$languages []= "<a href=\""."?".$_SERVER['QUERY_STRING']."&language=$value\">$value</a>";
	
	}
	$smarty->assign('languages', $languages);
	*/

	
	//////////////////////////////////
//ob_clean();//clean the output buffer.
header("Content-Type: text/html");
$smarty->template_dir = __INICROND_INCLUDE_PATH__."".'templates/';
   

if ($_OPTIONS['html_output_on_one_line'] == '1')
{
	 
    $output = $smarty->fetch($_OPTIONS['theme']."/index.tpl");
    
    $output = str_replace("\n",'',$output);
    $output = str_replace("\t",'',$output);
    $output = str_replace("\r",'',$output);
    echo $output;


}
else
{
    $smarty->display($_OPTIONS['theme']."/index.tpl");
}

?>
