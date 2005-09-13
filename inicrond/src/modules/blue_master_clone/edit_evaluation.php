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
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_cours_id.php";//init inicrond kernel


if(//list all groups for a course.
isset($_GET['ev_id']) AND
$_GET['ev_id'] != "" AND
(int) $_GET['ev_id'] AND
$cours_id = ev_id_to_cours_id($_GET['ev_id']) AND
is_teacher_of_cours($_SESSION['usr_id'], $cours_id)//a teacher only can see this very page.
)
{
        $module_title = $_LANG['edit_evaluation'];
        
        
        if(isset($_POST["envoi"]))//no data xsent, show the form.
        {
                //type casting to check the type...
                
                include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
                
                $_POST['ev_weight'] = str_replace(",", ".", $_POST['ev_weight']);
                $_POST['ev_max'] = str_replace(",", ".", $_POST['ev_max']);
                
                (float) $_POST['ev_weight'] ;
                (float) $_POST['ev_max'] ;
                
                $query = "UPDATE 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
                SET
                ev_name='".filter($_POST['ev_name'])."',
		ev_weight=".$_POST['ev_weight'].",
		ev_max=".$_POST['ev_max'].",
		comments='".filter($_POST['comments'])."',
		available = '".$_POST['available']."',
		ev_final = '".$_POST['ev_final']."'
                
                WHERE
		ev_id=".$_GET['ev_id']."
                
                ";
                $inicrond_db->Execute($query);
                
                
                
        }
        $query = "SELECT 
        ev_name,
        ev_weight,
        ev_max,
        comments,
        available,
        ev_final
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        
        WHERE
        ev_id=".$_GET['ev_id']."
        
        ";
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        //form can send files.
        $module_content = "<form method=\"POST\" >";
        $tableau_to_print = array(array("&nbsp;", "&nbsp;"));
        
        $tableau_to_print []= array(
        $_LANG['ev_name'],
        "<input type=\"text\" value=\"".$fetch_result['ev_name']."\"name=\"ev_name\" />");
        
        $tableau_to_print []= array(
        $_LANG['ev_weight'],
        "<input type=\"text\" value=\"".$fetch_result['ev_weight']."\"name=\"ev_weight\" />");
        
        $tableau_to_print []= array(
        $_LANG['ev_max'],
        "<input type=\"text\" value=\"".$fetch_result['ev_max']."\"name=\"ev_max\" />");
        
        $tableau_to_print []= array(
        $_LANG['comments'],
        "<textarea name=\"comments\">".$fetch_result['comments']."</textarea>");
        
        
        $tableau_to_print []= array(
        $_LANG['available'],
        
        ($fetch_result['available']) ?
        
        "<select name=\"available\">
        <option SELECTED value=\"1\">".$_LANG['available']."</option>
        <option value=\"0\">".$_LANG['not_available']."</option>
        </select>" ://the yes is selected.
        
        "<select name=\"available\">
        <option value=\"1\">".$_LANG['available']."</option>
        <option SELECTED value=\"0\">".$_LANG['not_available']."</option>
        </select>"//the no is selected.
        
        );
        
        
        //ev_final.
        $tableau_to_print []= array(
        $_LANG['ev_final'],
        
        ($fetch_result['ev_final']) ?
        
        "<select name=\"ev_final\">
        <option SELECTED value=\"1\">".$_LANG['yes']."</option>
        <option value=\"0\">".$_LANG['no']."</option>
        </select>" ://the yes is selected.
        
        "<select name=\"ev_final\">
        <option value=\"1\">".$_LANG['yes']."</option>
        <option SELECTED value=\"0\">".$_LANG['no']."</option>
        </select>"//the no is selected.
        
        );
        
        
        
        
        $module_content .= retournerTableauXY($tableau_to_print);
        $module_content .= "<input type=\"submit\" name=\"envoi\" /> ";
        
        $module_content .= "</form>";
        
        
        
        
        
        
        //INSERT CODE HERE.
        
        
        include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_group_id.php";//init inicrond kernel
        
        $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".ev_id_to_group_id($_GET['ev_id'])."\">".$_LANG['return']."</a></h4>";
        
        
}

include "../../includes/kernel/post_modulation.php";
?>