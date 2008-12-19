<?php
/*
    $Id: see_online_people_for_a_course.php 85 2005-12-27 03:22:23Z sebhtml $

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

$module_content = '' ;

if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int)$_GET['cours_id']
&& is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id']))
{
    $now = inicrond_mktime();

    $query =
    //requ�e pour toutes les sessions...
    "
    SELECT
    usr_nom,
    usr_prenom,
    usr_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
    $now-end_gmt_timestamp,
    HTTP_USER_AGENT,
    REMOTE_ADDR,
    dns,
    end_gmt_timestamp,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id AS session_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    AND
    is_online= '1'
    AND
    cours_id=".$_GET['cours_id']."
    ORDER BY end_gmt_timestamp DESC
    ";

    $rs = $inicrond_db->Execute($query);

    $online_ppl = array(
    array($_LANG['usr_nom'], $_LANG['usr_name'], $_LANG['date'], $_LANG['dns'], $_LANG['usr_page_title'])
    );

    while ($f = $rs->FetchRow ())
    {
        $query =
        //requête pour toutes les sessions...
        "
        SELECT
        requested_url,
        usr_page_title
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['page_views']."
        WHERE
        session_id=".$f['session_id']."
        ORDER BY page_id DESC
        ";

        $rs2 = $inicrond_db->Execute ($query);
        $fetch_result = $rs2->FetchRow();

        $online_ppl []= array(
        $f['usr_nom'].", ".$f['usr_prenom'],
        "<a href=\""."".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$f['usr_id']."\">".$f['usr_name']."</a>",
        "".format_time_stamp($f['end_gmt_timestamp'])." (-".format_time_length($f["$now-end_gmt_timestamp"]).")
        ",
        "
        <a href=\""."".__INICROND_INCLUDE_PATH__."modules/seSSi/one_session_page_views.php?session_id=".$f['session_id']."\"> ".$f['dns']." (".$f['REMOTE_ADDR'].") ".$f['HTTP_USER_AGENT']."</a>
        ",
        "
        ".$fetch_result['usr_page_title']."
        "
        );
    }

    $module_title = $_LANG['see_online_people_for_a_course'];
    $course_infos =  get_cours_infos($_GET['cours_id']);
    $smarty->assign('course_infos', $course_infos);
    $smarty->assign('online_ppl', $online_ppl);
    $module_content .=  $smarty->fetch($_OPTIONS['theme']."/see_online_people_for_a_course.tpl");
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>