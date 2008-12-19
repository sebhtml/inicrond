<?php
/*
    $Id: see_online_people.php 85 2005-12-27 03:22:23Z sebhtml $

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

if($_SESSION['SUID'])
{
    $now = inicrond_mktime();

    $query =
    //requ�e pour toutes les sessions...
    "
    SELECT
    usr_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
    $now-end_gmt_timestamp,
    HTTP_USER_AGENT,
    REMOTE_ADDR,
    dns,
    end_gmt_timestamp,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id,
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    AND
    is_online='1'
    ORDER BY end_gmt_timestamp DESC
    ";

    $rs = $inicrond_db->Execute($query);

    $online_ppl = array(array($_LANG['usr_name'], $_LANG['date'], $_LANG['dns'], $_LANG['usr_page_title']));

    while ($f = $rs->FetchRow())
    {
        $query =
        //requ�e pour toutes les sessions...
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

        $rs2 = $inicrond_db->Execute($query);
        $fetch_result = $rs2->FetchRow();

        $online_ppl []= array(

        "<small>
        <a href=\""."../../modules/members/one.php?usr_id=".$f['usr_id']."\">".$f['usr_name']."</a>
        </small>",
        "<small>
        ".format_time_stamp($f['end_gmt_timestamp'])." (-".format_time_length($f["$now-end_gmt_timestamp"]).")
        </small>",
        "<small>
        <a href=\""."../../modules/seSSi/one_session_page_views.php?session_id=".$f['session_id']."\"> ".$f['dns']." (".$f['REMOTE_ADDR'].") ".$f['HTTP_USER_AGENT']."</a>
        </small>",
        "<small>
        ".$f['cours_id'].' '.$fetch_result['usr_page_title']."
        </small>"
        );
    }

    $module_title = $_LANG['see_online_people'];
    $module_content .= "<h2><a href=\"../../modules/admin/admin_menu.php\">".$_LANG['admin']."</a></h2>";

    $smarty->assign('online_ppl', $online_ppl);
    $module_content .=  $smarty->fetch($_OPTIONS['theme']."/see_online_people.tpl");
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>