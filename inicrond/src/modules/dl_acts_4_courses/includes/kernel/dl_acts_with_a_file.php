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

include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";
//include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

$query = "
SELECT
file_name,
cours_name,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id AS cours_id
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
WHERE
file_id=".$_GET['file_id']."
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
and
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id
";

$rs = $inicrond_db->Execute($query);
$fetch_result = $rs->FetchRow();

$cours_id = $fetch_result['cours_id'];

$module_title =  $_LANG['dl_acts_4_courses'];


if(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
//check if he / she is in charge of this group.
&&  isset($_GET['join'])
&& is_in_charge_in_course($_SESSION['usr_id'], group_id_to_cours_id($_GET['group_id'])))
{//begin of if

    $FROM_WHAT .=//add the groups_usrs table dude...
    ", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."";

    $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_GET['file_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    ";

    $base .= "&file_id=".$_GET['file_id']."&group_id=".$_GET['group_id'];

}//end of if
elseif(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
//check if he / she is in charge of this group.
//do the join with a usr_id and a file_id
&& isset($_GET['join']) && is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
{//begin of elseif

    $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_GET['file_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_GET['usr_id']."     ";
    $base .= "&file_id=".$_GET['file_id']."&usr_id=".$_GET['usr_id'];

    $module_content .= "<a href=\"../../modules/dl_acts_4_courses/downloads_graphic.php?usr_id=".$_GET['usr_id']."&file_id=".$_GET['file_id']."\" >".$_LANG['downloads_graphic']."</a><br />";

}//end of elseif

else//don't do any join, only do for a file_id.
{//begin of else.

    $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_GET['file_id']."
    ";
    $base .= "&file_id=".$_GET['file_id'];

    //list all the groups that are in the course.
    $sql_4_groups = "
    SELECT
    group_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    cours_id=$cours_id
    ";

    $rs = $inicrond_db->Execute($sql_4_groups);

    $tableX = array(array($_LANG['groups']));
    $already_there = array();

    while($f = $rs->FetchRow())
    {
        $tableX []= array(retournerHref("?file_id=".$_GET['file_id']."&group_id=".$f['group_id']."&join",
        $f['group_name']));
    }

    $module_content .= retournerTableauXY($tableX);

    //list all the usr that have downloaded this very file.

    $query = "
    SELECT
    usr_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
    WHERE

    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_GET['file_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".session_id
    GROUP BY ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
    ";

    $tableX = array(array($_LANG['members']));

    $rs = $inicrond_db->Execute($query);
    while( $f = $rs->FetchRow())
    {
        $tableX []= array(retournerHref("?file_id=".$_GET['file_id']."&usr_id=".$f['usr_id']."&join",
        $f['usr_name']));
    }

    $module_content .= retournerTableauXY($tableX);
}//end of else

?>