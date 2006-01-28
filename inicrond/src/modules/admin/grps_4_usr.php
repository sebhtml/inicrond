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

if(isset($_SESSION['usr_id']) &&
isset($_GET['usr_id']) &&
(int) $_GET['usr_id'] &&
$_SESSION['SUID'])
{
        $module_title =  $_LANG['change_grps_for_usr'];
        
        if(isset($_POST["data_sent"]))
        {
        	$query = "DELETE
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                usr_id=".$_GET['usr_id']."
                ";
                
                $inicrond_db->Execute($query);
                
                foreach($_POST AS $key => $value)
                {
                        if(preg_match("/group_id=(.+)/", $key, $tokens))
                        //les txt pour les answer.
                        {
                                $query = "INSERT INTO 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                                (usr_id, group_id)
                                VALUES
                                (".$_GET['usr_id'].", ".$tokens["1"].")
                                ";
                                
                                $inicrond_db->Execute($query);
                        }
                }
        }
        
        $module_content .= "<form method=\"POST\">";
        //here list all group in this course except the current group.
        $tab = array(array($_LANG['group_name'], $_LANG['cours_code'], $_LANG['cours_name'], $_LANG['checkbox']));
        $query = "SELECT 
        group_id,
        group_name,
        cours_name,
        cours_code
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
        
        ORDER BY  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id ASC
        
        ";
        
	$rs = $inicrond_db->Execute($query);
	
	while($fetch_result = $rs->FetchRow())//foreach group, check if the group is in charge of the current group.
	{
		$query = "SELECT 
		usr_id
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']." 
                WHERE
		usr_id=".$_GET['usr_id']."
		AND
		group_id = ".$fetch_result['group_id']."
                ";
                
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result2 = $rs2->FetchRow();
                
                $checked = isset($fetch_result2['usr_id']) ? "CHECKED" : "" ;
		
                $tab []= array($fetch_result['group_name'], $fetch_result['cours_code'], $fetch_result['cours_name'], " <input $checked type=\"checkbox\" name=\"group_id=".$fetch_result['group_id']."\" value=\"\" />");	
	}
        
        $module_content .= retournerTableauXY($tab);	
        
        $module_content .= "<input  type=\"submit\" name=\"data_sent\" /> </form>";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>