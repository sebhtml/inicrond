<?php
/*
    $Id: one.php 85 2005-12-27 03:22:23Z sebhtml $

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

define ('__INICROND_INCLUDED__', true);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include 'includes/functions/access.inc.php';
include 'includes/functions/do_user_know_user.php';

if (isset($_SESSION['usr_id']) && isset($_GET['usr_id']) && $_GET['usr_id'] != ""
&& (int) $_GET['usr_id'] && do_user_know_user($_SESSION['usr_id'], $_GET['usr_id']))
{
    $is_in_charge_of_user = is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']);

    $query = "
    SELECT
    usr_id,
    usr_name,
    usr_add_gmt_timestamp,
    usr_email,
    usr_nom,
    usr_prenom,
    show_email,
    usr_signature,
    usr_number
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    usr_id=".$_GET['usr_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $usr['usr_id'] = $fetch_result['usr_id'];
    $usr['usr_name'] = $fetch_result['usr_name'];
    $usr['usr_nom'] = $fetch_result['usr_nom'];
    $usr['usr_prenom'] = $fetch_result['usr_prenom'];

    $usr['usr_add_gmt_timestamp'] = format_time_stamp($fetch_result['usr_add_gmt_timestamp']);

    $usr["img"] = "<img src=\"download.php?&usr_id=".$_GET['usr_id']."\"/>" ;

    $usr['usr_signature'] = nl2br($fetch_result['usr_signature']);

    if ($is_in_charge_of_user || $fetch_result['show_email'] == '1')
    {
        $usr['usr_email'] = $fetch_result['usr_email'];
    }

    if ($is_in_charge_of_user)
    {
        $usr['usr_number'] = $fetch_result['usr_number'];
    }

    $module_title =  $_LANG['user_informations'];

    if (is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
    {
        if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
        {
            $cours_id = $_GET['cours_id'] ;

            $usr['seSSi'] = retournerHref("".__INICROND_INCLUDE_PATH__."modules/seSSi/one.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."", $_LANG['seSSi']) ;

            $usr['marks'] = retournerHref("".__INICROND_INCLUDE_PATH__."modules/marks/main.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."", $_LANG['marks'] );

            $usr['tests_results'] =                          retournerHref("".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."", $_LANG['tests-results']);

            $usr['dl_acts_4_courses'] =
            retournerHref("".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."",$_LANG['dl_acts_4_courses']);

            $usr['user_graphics_for_a_course'] = "<a href=\"".__INICROND_INCLUDE_PATH__."modules/inicrond_x/user_graphics_for_a_course.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\">".$_LANG['user_graphics_for_a_course']."</a>";
        }
        else
        {
            $usr['seSSi'] = retournerHref("".__INICROND_INCLUDE_PATH__."modules/seSSi/one.php?usr_id=".$_GET['usr_id']."", $_LANG['seSSi']) ;

            $usr['marks'] = retournerHref("".__INICROND_INCLUDE_PATH__."modules/marks/main.php?usr_id=".$_GET['usr_id']."", $_LANG['marks'] );

            $usr['tests_results'] =                          retournerHref("".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?usr_id=".$_GET['usr_id']."", $_LANG['tests-results']);

            $usr['dl_acts_4_courses'] =
            retournerHref("".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?usr_id=".$_GET['usr_id']."",$_LANG['dl_acts_4_courses']);
        }

        //list the courses of the user.

        $query = "
        SELECT
        cours_code,
        cours_name,
        T_groups.cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." AS T_groups,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']." AS T_group_user,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." AS T_courses
        WHERE
        T_courses.cours_id= T_groups.cours_id
        AND
        T_group_user.usr_id=".$_GET['usr_id']."
        AND
        T_groups.group_id=T_group_user.group_id
        GROUP BY T_courses.cours_id
        ";

        $rs = $inicrond_db->Execute($query);

        $usr['courses_list_for_a_user'] = array();

        while ($fetch_result = $rs->FetchRow())
        {
            $usr['courses_list_for_a_user']  []= "<a href=\"?usr_id=".$_GET['usr_id']."&cours_id=".$fetch_result['cours_id']."\""."<b>".$fetch_result['cours_code']."</b> <i>".$fetch_result['cours_name']."</i>"."</a>";
        }

    }//end of he is charge.

    if($_SESSION['SUID'])
    {
        $usr['change_grps_for_usr'] = retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/grps_4_usr.php?usr_id=".$_GET['usr_id'],$_LANG['change_grps_for_usr']);

        $usr['login_as'] = retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/master_login.php?usr_id=".$_GET['usr_id'],$_LANG['login_as']);
    }

    //courses_list_for_a_user
    $smarty->assign("usr", $usr);
    $smarty->assign("_LANG", $_LANG);
    $module_content .= $smarty->fetch($_OPTIONS['theme']."/user_informations.tpl");

} // end of security check.

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>