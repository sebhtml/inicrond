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


if(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
&& is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']))//edit
{
    $query = "
    SELECT
    group_name,
    default_pending
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $module_title =  $fetch_result['group_name'];

    if(!isset($_POST['group_name']))
    {
        $module_content .=  "
        <form method=\"POST\">
        ".  $_LANG['group_name']." : <input type=\"text\" name=\"group_name\" value=\"".$fetch_result['group_name']."\" /><br /> ";

        $module_content .=   $_LANG['default_pending']." : ";
        $module_content .=   $fetch_result['default_pending'] ?

        "<select name=\"default_pending\">
        <option SELECTED value=\"1\">".$_LANG['yes']."</option>
        <option value=\"0\">".$_LANG['no']."</option>
        </select>" ://the yes is selected.

        "<select name=\"default_pending\">
        <option value=\"1\">".$_LANG['yes']."</option>
        <option SELECTED value=\"0\">".$_LANG['no']."</option>
        </select>"//the no is selected
        ;

        $module_content .="
        <br /><input type=\"submit\"    />
        </form>" ;
    }
    else
    {
        $group_name = $_POST['group_name'];

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        SET
        group_name='".$_POST['group_name']."',
        default_pending='".$_POST['default_pending']."'
        WHERE
        group_id=".$_GET['group_id']."
        ";

        $inicrond_db->Execute($query);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";

        js_redir("course_groups_listing.php?cours_id=".group_id_to_cours_id($_GET['group_id']));
    }
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>