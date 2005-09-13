<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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
include __INICROND_INCLUDE_PATH__."modules/user/includes/constants/constants.php";


if(
$_SESSION['SUID']

)
{
        $module_content .= "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
        $module_title =  $_LANG['list_user_in_0_group'];
        /*
        //get the users in no groups.
        
        //set the query
	$query = "SELECT
	T_users.usr_id, usr_name, usr_nom, usr_prenom, COUNT(T_groups_users.usr_id) AS nb_groups
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." AS T_users LEFT JOIN
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']." AS T_groups_users
        ON
	(T_users.usr_id = T_groups_users.usr_id)
        
	GROUP BY T_groups_users.usr_id
	ORDER BY usr_name  ASC
	";
        
	$rs = $inicrond_db->Execute($query);
        $usrs_table = array(
        array(
        $_LANG['usr_name'],
        $_LANG['usr_nom'],
        $_LANG['usr_prenom'],
        $_LANG['nb_groups']
        )
        );
        $i = 0;
        while($fetch_result = $rs->FetchRow())
        {
		if($fetch_result['nb_groups'])//!=0
		{
                        continue;
		}
		$usrs_table []= array(
                '<a href="'.
                __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'].'">'.$fetch_result['usr_name'].'</a>',
                $fetch_result['usr_nom'],
                $fetch_result['usr_prenom'],
                $fetch_result['nb_groups']
                
                );
                $i++;
                
        }
        
        //echo $i;//debug stuff.
        
        $module_content .= retournerTableauXY($usrs_table);
	*/
        
        //second method with more query...
        //to verify that the first one is working.
        ///////////////////////////////////////////////////////////////////////////////////////////
        
        //set the query
	$query = "SELECT
	T_users.usr_id, usr_name, usr_nom, usr_prenom 
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." AS T_users
	";
        
	$rs = $inicrond_db->Execute($query);
        $usrs_table = array(
        array(
        $_LANG['usr_name'],
        $_LANG['usr_nom'],
        $_LANG['usr_prenom']
        )
        );
        //$i = 0;
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
                        //$i++;
                }
                
        }
        
        $module_content .= retournerTableauXY($usrs_table);
        
        
	
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>