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

if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id']
&& is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))//check if the get is ok to understand.
{
    //add the title :
    $module_title = $_LANG['course_groups_listing'];

    $course_infos =  get_cours_infos($_GET['cours_id']);

    $course_groups = array(
    array( $_LANG['group_name'], $_LANG['default_pending'], $_LANG['edit']));

    $query = "
    SELECT
    group_id,
    group_name,
    default_pending
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    cours_id=".$_GET['cours_id']."
    order by add_time_t desc
    ";

    $rs = $inicrond_db->Execute($query);

    while ($fetch_result = $rs->FetchRow())
    {
        $course_groups []= array
        (

        "<a href=\"".__INICROND_INCLUDE_PATH__.
            "modules/groups/grp.php?&group_id=".$fetch_result['group_id']."\">
            ".$fetch_result['group_name']."</a>",

        $fetch_result['default_pending'] ? $_LANG['yes']:
            "<b><span style=\"color: red;\">".$_LANG['no']."</span></b>",

        "<a href=\"".__INICROND_INCLUDE_PATH__."modules/groups/edit_a_group.php?&group_id=".
            $fetch_result['group_id']."\"><img border=\"0\" src=\"".__INICROND_INCLUDE_PATH__.
                "modules/courses/templates/inicrond_default/images/b_edit.png\" /></a>"
        );
    }

    //assign smarty variables.
    $smarty->assign('course_infos', $course_infos);
    $smarty->assign('course_groups', $course_groups);
    $smarty->assign('_LANG', $_LANG);
    $smarty->assign('cours_id', $_GET['cours_id']);

    $module_content .=  $smarty->fetch($_OPTIONS['theme']."/course_groups_listing.tpl");

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>