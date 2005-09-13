<?php
/*---------------------------------------------------------------------

$Id$

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
define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.

include "includes/etc/final_mark_formula.php";//init inicrond kernel
include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";//init inicrond kernel

if(//list all groups for a course.
isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND
$cours_id = group_id_to_cours_id($_GET['group_id']) AND
is_teacher_of_cours($_SESSION['usr_id'], $cours_id)//a teacher only can see this very page.
)
{
        
        include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/inicrond_compute_final_mark.php";
        
        
        $module_title = $_LANG['final_mark_output'];
        
        //show some informations.
        $query = "SELECT
	
        group_id,
        group_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
        cours_code,
        cours_name
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." 
        WHERE 
        group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        foreach($fetch_result AS $key => $value)
        {
                $module_content .= $_LANG[$key]. " : ".$value."<br />";
        }
        
        $module_content .= "<br /><br />";
        
        
        //output all final marks for this very group.
        $query = "SELECT 
        usr_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
        usr_prenom,
        usr_nom
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        AND
        group_id=".$_GET['group_id']."
        
        
        ";
        
        
        
	$query .= " ORDER BY usr_nom ASC " ;
        $rs = $inicrond_db->Execute($query);
        
        $tableau = array(array(
        $_LANG['usr_nom'], 
        $_LANG['usr_prenom'], 
        $_LANG['usr_id'], 
        $_LANG['usr_name'], 
        $_LANG['percentage']));
        
        //$i = 1 ;   
        while($fetch_result = $rs->FetchRow())
        {
                $mark = inicrond_compute_final_mark($fetch_result['usr_id'], $_GET['group_id']);
                
                $tableau []= array(
                $fetch_result['usr_nom'], 
                $fetch_result['usr_prenom'], 
                $fetch_result['usr_id'], 
                $fetch_result['usr_name'], 
                $mark['percentage']);
                
        }
        
        $module_content .= retournerTableauXY($tableau);
        
        $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".($_GET['group_id'])."\">".$_LANG['return']."</a></h4>";
        
}//end of security check.

//INSERT CODE HERE.

include "../../includes/kernel/post_modulation.php";
?>