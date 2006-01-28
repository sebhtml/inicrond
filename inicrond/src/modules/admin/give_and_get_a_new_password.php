<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if($_SESSION['SUID'])
{		
        $module_content .= "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
	
	//-----------------------
	// titre
	//---------------------
        $module_title =  $_LANG['give_and_get_a_new_password'];
        
	if(!isset($_POST["envoi"]))
	{
                include "includes/forms/pwd.form.php";
	}
	else//analyse des données
	{
                $query = "SELECT
                usr_id
		FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
		WHERE
		usr_name='".$_POST['usr_name']."'
		AND
		SUID='0'
		";
		
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
		if(!isset($fetch_result['usr_id']))
		{
                        $module_content .=  $_LANG['UtilisateurExistePas'];
		}
		else//usr valide
		{
                        include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";
                        $password = hex_gen_32();//hexadecimal string
			
                        $query = "UPDATE
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                        SET
                        usr_md5_password='".md5($password)."'
                        WHERE
                        usr_name='".$_POST['usr_name']."'
                        AND
                        SUID='0'
                        ";
                        
                        $inicrond_db->Execute($query);
                        
                        //	$module_content .=$query;
                        $module_content .=  $_LANG['usr_name']." : ".$_POST['usr_name'];
                        $module_content .=  "<br />";
                        $module_content .=  $_LANG['usr_password']." : ".$password;
		}
	}
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>