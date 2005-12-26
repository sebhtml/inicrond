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

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

include __INICROND_INCLUDE_PATH__."modules/inicrond_x/includes/languages/".$_SESSION['language'].'/lang.php';

if(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
&& $is_in_charge_of_group=is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']))
{
    $module_title =  $_LANG['a_group'];

    $group = array();

    $query = "
    SELECT
    group_id,
    group_name,
    cours_id,
    default_pending
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $cours_id = $fetch_result['cours_id'] ;

    $group['group_name'] = $fetch_result['group_name'];

    $group['group_id'] = $fetch_result['group_id'];

    $group['default_pending'] = $fetch_result['default_pending'] ? $_LANG['yes'] : $_LANG['no'];

    $group['graphics_for_a_group'] = "<a href=\"".__INICROND_INCLUDE_PATH__.
        "modules/inicrond_x/graphics_for_a_group.php?group_id=".
        $fetch_result['group_id']."\">".$_LANG['graphics_for_a_group']."</a>";

    $course_infos =  get_cours_infos($fetch_result['cours_id']);

    $smarty->assign('course_infos', $course_infos);

    $group['course_groups_listing'] = "<a href=\""."course_groups_listing.php?cours_id=".
        $fetch_result['cours_id']."\">".$_LANG['course_groups_listing']."</a>";

    $group['seSSi'] = retournerHref(__INICROND_INCLUDE_PATH__.
        "modules/seSSi/one.php?group_id=".$_GET['group_id'], $_LANG['seSSi']);

    $group['get_group_emails'] = retournerHref("get_group_emails.php?group_id=".
        $_GET['group_id'], $_LANG['get_group_emails']);

    $group['marks'] = retournerHref(__INICROND_INCLUDE_PATH__.
        "modules/marks/main.php?group_id=".$_GET['group_id'], $_LANG['marks']);

    $group['tests_results'] = retournerHref(__INICROND_INCLUDE_PATH__.
        "modules/tests-results/results.php?group_id=".$_GET['group_id'], $_LANG['tests-results']);

    $group['dl_acts_4_courses'] = retournerHref(__INICROND_INCLUDE_PATH__.
        "modules/dl_acts_4_courses/show_dl_acts.mo.php?group_id=".
        $_GET['group_id'], $_LANG['dl_acts_4_courses']);

    if(is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']))//echef du groupe seulement
    {
        $group['edit'] = retournerHref("edit_a_group.php?group_id=".$_GET['group_id'], $_LANG['edit']);

        $group['divide_a_group'] = retournerHref("divide_a_group.php?group_id=".
            $_GET['group_id'], $_LANG['divide_a_group']);

        $group['remove_group'] = retournerHref("remove_a_group.php?group_id=".$_GET['group_id'],
            $_LANG['remove_group']);

        $group['update_group_password'] = retournerHref("update_group_password.php?group_id=".
            $_GET['group_id'], $_LANG['update_group_password']);
    }

    //USERS OF THIS GROUP.

    $group["users"]  = array ();

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id, usr_name, usr_nom, usr_prenom
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
    ORDER BY usr_nom ASC";

    $rs = $inicrond_db->Execute($query);

    while($fetch_result = $rs->FetchRow())
    {
        $group["users"] []= array(
        "usr_link" => __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".
            $fetch_result['usr_id']."&cours_id=$cours_id",
        'usr_nom' => $fetch_result['usr_nom'],
        'usr_prenom' => $fetch_result['usr_prenom'],
        'usr_id' => $fetch_result['usr_id'],
        'usr_name' => $fetch_result['usr_name'],
        "remove_user_link" => "remove_a_user_from_a_group.php?usr_id=".$fetch_result['usr_id']."&group_id=".$_GET['group_id'].""
        );
    }

    $smarty->assign("group", $group);
    $smarty->assign("_LANG", $_LANG);
    $module_content .= $smarty->fetch($_OPTIONS['theme']."/group_informations.tpl");

}//master security check

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>