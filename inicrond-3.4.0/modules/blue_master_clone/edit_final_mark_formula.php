<?php
/*
    $Id: edit_final_mark_formula.php 87 2006-01-01 02:20:14Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/group_id_to_cours_id.php';//init inicrond kernel

include 'includes/etc/final_mark_formula.php'; //init inicrond kernel

if(isset($_GET['group_id']) //list all groups for a course.
&& $_GET['group_id'] != ""
&& (int) $_GET['group_id']
&& is_teacher_of_cours($_SESSION['usr_id'], group_id_to_cours_id($_GET['group_id'])))//a teacher only can see this very page.
{
    $cours_id = group_id_to_cours_id($_GET['group_id']) ;

    $module_title = $_LANG['edit_final_mark_formula'];

    if(isset($_POST['final_mark_formula']))//upodate the formula...
    {
        $query = "UPDATE

        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        SET
        final_mark_formula='".$_POST['final_mark_formula']."'
        WHERE
        group_id=".$_GET['group_id']."
        ";

        $inicrond_db->Execute($query);
    }

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
    $query = "SELECT
    final_mark_formula
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $module_content .= $_LANG['final_mark_formula']."<br /><form method=\"POST\"><select name=\"final_mark_formula\">";

    foreach($final_mark_formula AS $key => $value)
    {
        $module_content .= "<option ".
        ($key == $fetch_result['final_mark_formula'] ? "SELECTED" : "").
        " value=\"$key\">".$_LANG[$value]."</option>";
    }

    $module_content .= "</select><input type=\"submit\" /></form><br /><br />";

    //////////////
    //output the formula descriptions.

    foreach($final_mark_formula AS $key => $value)
    {
        $module_content .= "<b>".$_LANG[$value]."</b> : <br />".nl2br($_LANG[$value."_info"])."<br /><br />";
    }

    $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".($_GET['group_id'])."\">".$_LANG['return']."</a></h4>";

}//end of security check.

include '../../includes/kernel/post_modulation.php';

?>