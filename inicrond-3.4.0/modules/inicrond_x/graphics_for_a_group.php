<?php
/*
    $Id: graphics_for_a_group.php 84 2005-12-26 20:31:43Z sebhtml $

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
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

if(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
&& is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']))
{
    $module_title = $_LANG['graphics_for_a_group'];

    /////////////////////////////////
    //get the group name, group id cours_id cours_name cours_code, every persons in the group.
    //show some informations.
    $query = "
    SELECT
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

    $cours_id = $fetch_result['cours_id'] ;

    //get all users in this group.
    //with a link to the profile with this cours_id.

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
    usr_name,
    usr_nom,
    usr_prenom
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
    WHERE
    group_id=".$_GET['group_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
    ";

    $rs = $inicrond_db->Execute($query);

    $tableau = array(array($_LANG['usr_name'], $_LANG['usr_nom'], $_LANG['usr_prenom']));

    while($fetch_result = $rs->FetchRow())
    {
        $tableau []= array("<a href=\"".__INICROND_INCLUDE_PATH__.
            "modules/members/one.php?usr_id=".$fetch_result['usr_id']."&cours_id=$cours_id\">".
            $fetch_result['usr_name']."</a>", $fetch_result['usr_nom'], $fetch_result['usr_prenom']);
    }

    $module_content .= retournerTableauXY($tableau);

    /////////////////////////////////////////////////////////
    //Sessions.

    //link to the sessions of this user.
    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/one.php?group_id=".$_GET['group_id']."\"><h2>".$_LANG['visits']."</h2></a><br /><br />";

    //image of visits...
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/sessions_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //image of time length of vvisits.
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/normal_dist_time_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    /////////////////////////////////////////////////////////
    //Flash results.

    //link to brute results.
    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/marks/main.php?group_id=".$_GET['group_id']."\"><h2>".$_LANG['marks']."</h2></a><br /><br />";

    ////////////////
    //correlation
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/time_vs_score_img.php?group_id=".$_GET['group_id']."\"><br /><br />";


    //marks
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //length
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_time_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //attempts
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/attempts_graphic.php?group_id=".$_GET['group_id']."\"><br /><br />";

    /////////////////////////////////////////////////////////
    //Tests results.

    //link to brute results.
    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?group_id=".$_GET['group_id']."\"><h2>".$_LANG['tests-results']."</h2></a><br /><br />";

    //correlation
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/correl_time_vs_score.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //marks
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //length
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_time_img.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //attempts
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/attempts_graphic.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //////////////////////////////////
    //Forums stuff

    $module_content .= "<h2>".$_LANG['mod_forum']."</h2>";
    //lthreads views
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/threads_views.php?group_id=".$_GET['group_id']."\"><br /><br />";

    //posts.
    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/posts_graphic.php?group_id=".$_GET['group_id']."\"><br /><br />";

    ///////////////////////
    //File downloads.
    //link to the sessions of this user.
    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?group_id=".$_GET['group_id']."\"><h2>".$_LANG['dl_acts_4_courses']."</h2></a><br /><br />";

    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/downloads_graphic.php?group_id=".$_GET['group_id']."\"><br /><br />";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>