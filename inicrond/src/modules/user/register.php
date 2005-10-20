<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//

//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisvert

http://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

if(!isset($_SESSION['usr_id']))//création de personnages
{
        
        
        
	//-----------------------
	// titre
	//---------------------
        
	
        $module_title = $_LANG['sign_in'];
        
        
	if(!isset($_POST['usr_name']))
	{
                
                
                $fetch_result['usr_time_decal'] = $_OPTIONS['usr_time_decal'];
                $fetch_result['language'] = $_OPTIONS['language'];
                
                //the form.
                
                include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
                include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
                include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";
                
                $module_content .=  "<form method=\"POST\" enctype=\"multipart/form-data\">
                <table border =\"0\" cellspacing=\"5\" cellpadding=\"5\" >
                " ;
                
                
                if(!isset($_SESSION['usr_id']))//seulement à la création
                {
                        
                        
                        
                        $usr_name_field = "<input type=\"text\" name=\"usr_name\" value=\"\" />"."<br />";
                        
                        
                        
                }
                else
                {
                        $usr_name_field = $fetch_result['usr_name'];
                }
                $module_content .=  "	
                <tr>
                <td ><span title=\"".$_OPTIONS['preg_usr']."\">".$_LANG['usr_name']."
                </span>
                </td>
                <td >$usr_name_field
                </td>
                <td><p align=\"justify\"></p>
                </td>
                </tr>
                "
                ;
                
                
                $select = new Select();
                $select->set_name('show_email');
                
                $my_option = new Option();
                if($fetch_result['show_email'] == 0)
                {
                        $my_option->selected();//SELECTED
                }
                $my_option->set_value("0");
                $my_option->set_text($_LANG['no']);
                $select->add_option($my_option);
                
                $my_option = new Option();
                if($fetch_result['show_email'] == 1)
                {
                        $my_option->selected();//SELECTED
                }
                
                $my_option->set_value("1");
                $my_option->set_text($_LANG['yes']);
                $select->add_option($my_option);
                
                $select->validate();
                
                
                
                $email_field = "<input type=\"text\" name=\"usr_email\" value=\"".$fetch_result['usr_email']."\" />";
                
                
                $module_content .=  "  <tr>
                <td  valign=\"top\">".$_LANG['usr_email']."<br /><b><span style=\"color: red;\"></span></b></td>
                <td  valign=\"top\">$email_field</td>
                <td  valign=\"top\">";
                if(isset($_SESSION['usr_id']))//seulement à la création
                {  
                        $module_content .=	  "".$_LANG['show_email']." ".$select->get_form_o()."";
                        
                }  
                $module_content .=	  "
                </td>
                </tr>";
                
                $module_content .= "
                <tr>
                <td >".$_LANG['usr_nom']."
                </td>
                <td><input type=\"text\" name=\"usr_nom\" value=\"".$fetch_result['usr_nom']."\" />
                </td>
                <td >
                
                </td>
                </tr>
                <tr>
                <td >".$_LANG['usr_prenom']."</td>
                <td >
                <input type=\"text\" name=\"usr_prenom\" value=\"".$fetch_result['usr_prenom']."\" />
                </td>
                <td >
                </td>
                </tr>";
                
                // if(isset($_SESSION['usr_id']))//seulement à la création
                //{
                        "
                        <tr>
                        <td >".$_LANG['usr_number']." (".$_LANG['not_necessary'].")</td>
                        <td >
                        <input type=\"text\" name=\"usr_number\" value=\"".$fetch_result['usr_number']."\" />
                        </td>
                        <td>
                        </td>
                        </tr>";
                        
                //}
                
                
                $module_content .=  "
                <tr>
                <td valign=\"top\" ><span title=\"".$_OPTIONS['preg_usr']."\">".$_LANG['usr_password']."
                </span>
                </td>
                <td valign=\"top\" ><input type=\"password\" name=\"usr_password\"  value=\"\" /><br /><b><span style=\"color: red;\"></span></b>"."
                
                
                </td>
                <td  valign=\"top\" rowspan=\"2\">
                "."<td />
                </tr>
                <tr>
                <td  valign=\"top\">".$_LANG['usr_password_2']."
                </td>
                <td  valign=\"top\">
                <input type=\"password\" name=\"usr_password_2\" value=\"\" /><br /><b><span style=\"color: red;\"></span></b>"."  </td>
                
                </tr>";
                
                
                
                
                
                
                
                
                
                $module_content .= "  
                <tr><td> <input type=\"submit\" name=\"envoi\"\" /></td></tr></table>	
                
                
                </form>" ;
                
	}
	elseif(($_POST['usr_password'] != $_POST['usr_password_2']))
	{
                
                
                $module_content .=  $_LANG['doublePass'];
	}
	elseif(!preg_match($_OPTIONS['preg_usr'],  $_POST['usr_password']) )
	{
                $module_content .=  $_LANG['password_wrong'];
	}
	elseif($_POST['usr_nom'] == "" )
	{
                $module_content .=  $_LANG['usr_nom_empty'];
	}
	elseif($_POST['usr_prenom'] == "" )
	{
                $module_content .=  $_LANG['usr_prenom_empty'];
	}
	elseif(!preg_match($_OPTIONS['preg_email'], $_POST['usr_email'] ) )
	{
                $module_content .=  $_LANG['error_email'];
	}
	elseif(	!preg_match($_OPTIONS['preg_usr'],  $_POST['usr_name'])
	)
	{
                $module_content .=  $_LANG['invalid_usr_name'];
	}
	else//on modifie !!!
	{
                
                $module_content .= 'd'.$_OPTIONS['preg_usr'].'D' ;
                
                include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
                
                $usr_name = filter($_POST['usr_name']);
		
                //insert l'utilisateur
                $query = "SELECT
                usr_id
                
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                WHERE
                usr_name='".$_POST['usr_name']."'
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                
                
                
                
                
		if(isset($fetch_result['usr_id']))
		{
                        $module_content .=  $_LANG['name_already_took'];
		}
		else//on ajoute
		{
                        // usr_name = da
                        
                        
                        
                        
                        //insert l'utilisateur
                        $query = "INSERT INTO
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." 
                        (
                        usr_name,
                        usr_md5_password,
                        usr_add_gmt_timestamp,
                        usr_email,
                        usr_prenom,
                        usr_nom
                        
                        )
                        VALUES
                        (
                        '".filter($_POST['usr_name'])."',
                        '".md5($_POST['usr_password'])."',
                        ".inicrond_mktime().",
                        '".$_POST['usr_email']."',
                        '".filter($_POST['usr_prenom'])."',
                        '".filter($_POST['usr_nom'])."'
                        )
                        ";	
                        
                        
                        $inicrond_db->Execute($query);
                        $usr_id = $inicrond_db->Insert_ID();
                        $module_content .=  $_LANG['you_can_connect'];
                        
                        
                        
                        
                        
                        
                        include __INICROND_INCLUDE_PATH__."modules/user/includes/constants/constants.php";
                        
                        //here I choose the kind of validation:
                        
                        include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_mail.php";
                        
                        if($_OPTIONS['register_validation_mode'] == MOD_USER_EMAIL_REGISTER_VALIDATION)
                        {
                                $register_random_validation = hex_gen_32();//hexadecimal string
                                $query = "UPDATE
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                                SET
                                register_random_validation='$register_random_validation',
                                usr_activation=0
                                WHERE
                                usr_id=$usr_id";
                                
                                $inicrond_db->Execute($query);
                                
                                $module_content .= "<br />".$_LANG['you_received_an_email_to_validate_your_registration'];
                                
                                
                                
                                
                                inicrond_mail(
                                $_POST['usr_email'],//email
                                sprintf($_LANG['account_validation'], $_OPTIONS['virtual_addr']),//object
                                sprintf($_LANG['here_are_your_account_information'], $_POST['usr_name'], $_POST['usr_password'])."<br />".
                                sprintf($_LANG['click_here_to_validate'],"<a href=\"". $_OPTIONS['virtual_addr']."modules/user/validate.php?&register_random_validation=$register_random_validation\">". $_OPTIONS['virtual_addr']."modules/user/validate.php?&register_random_validation=$register_random_validation</a>")//content
                                );
                                
                                //$module_content .= "\$mail = $mail<br />\$object = $object<br />\$body = $body";
                                
                        }
                        elseif($_OPTIONS['register_validation_mode'] == MOD_USER_ADMIN_REGISTER_VALIDATION)
                        {
                                $query = "UPDATE
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                                SET
                                usr_activation=0
                                WHERE
                                usr_id=$usr_id";
                                $inicrond_db->Execute($query);
                                
                                
                                
                                $module_content .= "<br />".$_LANG['an_admin_will_validate_your_account'];
                                
                                inicrond_mail(
                                $_POST['usr_email'],//email
                                sprintf($_LANG['account_information'], $_OPTIONS['virtual_addr']),//object
                                sprintf($_LANG['here_are_your_account_information'], $_POST['usr_name'], $_POST['usr_password'])//content
                                );
                                
                                
                        }
                        elseif($_OPTIONS['register_validation_mode'] == MOD_USER_NO_REGISTER_VALIDATION)
                        {
                                $module_content .= "<br />".$_LANG['your_account_is_activated'];
                                inicrond_mail(
                                $_POST['usr_email'],//email
                                sprintf($_LANG['account_information'], $_OPTIONS['virtual_addr']),//object
                                sprintf($_LANG['here_are_your_account_information'], $_POST['usr_name'], $_POST['usr_password'])//content
                                );
                        }
                        
                }
	}
	
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php'; 
?>
