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

include __INICROND_INCLUDE_PATH__."modules/groups/includes/languages/".$_SESSION['language'].'/lang.php';


if(isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
$_GET['usr_id'] == $_SESSION['usr_id']
) 

//étudiants...

{
        /*
        ajoute ou enl�e des groupe pour un étudiant
        */	
	
	
        
        
        $module_title =  $_LANG['my_groups'];
        
        
        
        if(isset($_POST['group_id']))//add group
        {
                
                //first off, check if the user is already in this group...
                //check if he is already in this group
                $query = "SELECT
                usr_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                group_id=".$_POST['group_id']."
                AND
                usr_id=".$_GET['usr_id']."
                
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result=  $rs->FetchRow();
                
                if(isset($fetch_result['usr_id']))//he/she is already in this group
                {
                        $module_content .= $_LANG['you_are_already_in_this_group'];
                }
                else
                {
			//
                        //le groupe...
                        //md5_pw_to_join
                        $query = "SELECT
                        default_pending,
                        md5_pw_to_join
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                        WHERE
                        group_id=".$_POST['group_id']."
                        
                        ";
                        $rs = $inicrond_db->Execute($query);
                        $fetch_result = $rs->FetchRow();
                        
                        if($fetch_result['default_pending'] == 1)//the group cannot be joined
                        {
                                $module_content .= $_LANG['the_group_cannot_be_joined_because_sign_in_is_over'];
                        }
                        elseif($fetch_result['md5_pw_to_join'] != md5($_POST['md5_pw_to_join']))
                        //the password is incorrect.
                        {
                                $module_content .= $_LANG['the_group_cannot_be_joined_because_the_password_is_incorrect'];
                        }
                        else//everynthing is ok.
                        {
                                $query = "INSERT INTO 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                                (group_id, usr_id)
                                VALUES
                                ('".$_POST['group_id'].	"', ".$_GET['usr_id']."
                                
                                )
                                ";
                                
                                $inicrond_db->Execute($query);
                                
                                
                                
                                
                                
                                
                                
                        }
                        //
                        //
                        //
                }//end of is not already in group  code
        }//end of database update.
        
	
        //---------------
        //add a group with the drop list.
        //++++++++++++++++++++++++
        
        
	//	$module_content .= "</td><td>";
	//check if theree is group with no pending.
	$query = "SELECT
        group_id
	
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        
        WHERE
        default_pending= '0'
        ";
        $ok = FALSE;//he is in all groups, we suppose that!.
        
        $rs = $inicrond_db->Execute($query);
        while($fetch_result =  $rs->FetchRow())//foreach group with open signin, check if the user is in already.
        {
                //check if he is already in this group
                $query = "SELECT
                usr_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                group_id=".$fetch_result['group_id']."
                AND
                usr_id=".$_GET['usr_id']."
                
                ";
                
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result=  $rs2->FetchRow();
		
                if(!isset($fetch_result['usr_id']))//BANG ! : he is not in this group
                {
                        $ok = TRUE;
                        break;
                }
        }
        
        //	$module_content .= "<table><tr><td>";	
        if($ok)
        {//do I show the select???
                
                $module_content .=  "<h2>".$_LANG['join_a_group_with_the_drop_list']."</h2>";	
                
                $module_content .= "<form method=\"POST\"><select name=\"group_id\">"; 
                
                //get all the group with no default_pending.
                $query = "SELECT
		group_id,
		group_name,
		cours_code,
		cours_name,
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id
		FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
		WHERE
		default_pending = '0'
		AND
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
		";
		
		$rs = $inicrond_db->Execute($query);
                
                while($r = $rs->FetchRow())
                {
                        //check if he is already in this group
                        $query = "SELECT
                        usr_id
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                        WHERE
                        group_id=\"".$r['group_id']."\"
                        AND
                        usr_id=".$_GET['usr_id']."
                        
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        $fetch_result=  $rs2->FetchRow();
                        
                        if(isset($fetch_result['usr_id']))//he/she is already in this group
                        {
                                continue;
                        }
                        
                        $module_content .= "<option value=\"".$r['group_id']."\">".
                        $r['group_name']." "." ".$r['cours_code']." ".$r['cours_name']." "
                        ."</option>";
                }//while , it is the end of while.

                $module_content .=  "</select><br />".$_LANG['md5_pw_to_join']." :
                <input type=\"password\" name=\"md5_pw_to_join\"  /><br />
                <input type=\"submit\"   />
                </form>";
                
                
	}//end of do I show the select?
	
	else//show an error that says that no group can be joined.
	{
                $module_content .= $_LANG['no_group_have_open_signin'];
	}
        
        //list the courses of the user.
        
        $query = "SELECT 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id, group_name, cours_code, cours_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_GET['usr_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
        
        ";

        $rs = $inicrond_db->Execute($query);
        
        $module_content .= "<br /><br />";
        
	while($fetch_result = $rs->FetchRow())
	{
                $module_content .= "<a href=\"?usr_id=".$_GET['usr_id']."&cours_id=".$fetch_result['cours_id']."\""."<b>".$fetch_result['cours_code']."</b> <i>".$fetch_result['cours_name']."</i>"." (".$fetch_result['group_name'].")"."</a><br />";
        }
}	
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>