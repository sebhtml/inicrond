<?php
/*
    $Id: inicrond_x_groups_selection.php 84 2005-12-26 20:31:43Z sebhtml $

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


if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id']
&& is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id']))
{//list the groups of this course.

    if(!isset($_POST["envoi"]))//show the form with check boxes
    {
        $module_title = $_LANG['inicrond_x_module'];

        $smarty->assign('course_infos', get_cours_infos( $_GET['cours_id']));

        $query = "
        SELECT
        group_id,
        group_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute($query);

        $form_elements = array(array($_LANG['group_name'], $_LANG['checkbox']));

        while($fetch_result = $rs->FetchRow())
        {
            $form_elements []= array($fetch_result['group_name'], "<input type=\"checkbox\"
            name=\"group_id=".$fetch_result['group_id']."\" value=\"group_id=".$fetch_result['group_id']."\" >");
        }

        $smarty->assign('form_elements', $form_elements);

        $module_content =  $smarty->fetch($_OPTIONS['theme']."/inicrond_x_groups_selection.tpl");
    }
    else//redirect to this very script with the group_id
    {
        foreach($_POST AS $key => $value)
        {
            if(preg_match("/group_id=(.+)/", $key, $tokens) )
            //les txt pour questions
            {
                $groups_list .= $tokens[1].",";
            }
        }

        //remove the last comma.
        $groups_list = substr($groups_list, 0, strlen($groups_list)-1);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir("inicrond_x_module.php?&group_id=$groups_list");
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>