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
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
//pear

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
$_GET['image'] = $_LANG['posts_graphic'];

$ok = FALSE;

$query = "
SELECT
forum_message_add_gmt_timestamp AS time_t
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
";

if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
&& is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
{
    $query2 = "
    SELECT
    usr_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    usr_id=".$_GET['usr_id']."
    ";

    $rs = $inicrond_db->Execute($query2);
    $fetch_result = $rs->FetchRow();

    $_GET["image"] .= "_".$fetch_result['usr_name'];//the file name...

    $ok = TRUE;
    $query .= " AND usr_id=".$_GET['usr_id']."";
}

if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
{
    $query .= " AND cours_id=".$_GET['cours_id'].""; //add cours_id clause.
}
elseif(is_numeric($_GET['group_id'])
&& is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']))
{
    $ok = 1 ;

    //////////////////
    //get the cours id for this group.

    //define the query in one shot...

    $query = "
    SELECT
    forum_message_add_gmt_timestamp AS time_t
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id = ".$_GET['group_id']."
    " ;
}
if(!$ok)
{
    exit();
}

$_GET["image"] .= ".png";

include __INICROND_INCLUDE_PATH__."includes/class/Peaks_graphic.php";

$Peaks_graphic = new Peaks_graphic;
$Peaks_graphic->inicrond_db = &$inicrond_db;
$Peaks_graphic->title = &$_LANG['posts_graphic'];
$Peaks_graphic->query = &$query;
$Peaks_graphic->render();

?>