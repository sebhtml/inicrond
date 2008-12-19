<?php
/*
    $Id: list_user_in_0_group.php 79 2005-12-21 14:37:07Z sebhtml $

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
include __INICROND_INCLUDE_PATH__."modules/user/includes/constants/constants.php";


if($_SESSION['SUID'])
{
        $module_content .= "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
        $module_title =  $_LANG['list_user_in_0_group'];
        
        //set the query
	$query = "SELECT
	T_users.usr_id, usr_name, usr_nom, usr_prenom 
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." AS T_users
	";
        
	$rs = $inicrond_db->Execute($query);
	
        $usrs_table = array
        	(
        		array
        		(
				$_LANG['usr_name'],
				$_LANG['usr_nom'],
        			$_LANG['usr_prenom']
        		)
        	);
        	
        while($fetch_result = $rs->FetchRow())
        {
		//check if the user has groups
		$query = 'SELECT
                COUNT(usr_id) AS nb_groups
                FROM
                '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].'
                WHERE
                usr_id = '.$fetch_result['usr_id'].'
                ';
                
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result2 = $rs2->FetchRow();
                
                if(!$fetch_result2['nb_groups'])//==0
                {
                        $usrs_table []= array(
                        '<a href="'.
                        __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'].'">'.$fetch_result['usr_name'].'</a>',
                        $fetch_result['usr_nom'],
                        $fetch_result['usr_prenom']
                        );
                }
        }
        
        $module_content .= retournerTableauXY($usrs_table);
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>