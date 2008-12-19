<?php
/*
    $Id: view_my_evaluations.php 82 2005-12-24 21:48:25Z sebhtml $

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


include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';//init inicrond kernel
include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";//init inicrond kernel


if(isset($_GET['cours_id']) &&
$_GET['cours_id'] != "" &&
(int) $_GET['cours_id'] &&
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
{
    //this file is asked for a usr and a group at the same time.

    $module_title = $_LANG['view_my_evaluations'];

    //lis a ll groups that this user is in for this course.
    $query = "SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id AS group_id, group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_GET['usr_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    cours_id=".$_GET['cours_id']."
    ";

    $course_infos =  get_cours_infos($_GET['cours_id'] );

    $module_content .= retournerTableauXY($course_infos)."<br />";

    $string = ''
    ;
    $rs = $inicrond_db->Execute($query);

    while($fetch_result = $rs->FetchRow())
    {
        $module_content .= "<a href=\"view_evaluations_with_a_group.php?group_id=".$fetch_result['group_id']."&usr_id=".$_GET['usr_id']."\">".$fetch_result['group_name']."</a> <br />";
    }

    //return to the home.

    $module_content .= "<h2><a href=\"blue_master_clone.php?cours_id=".$_GET['cours_id']."\">".$_LANG['return']."</a></h2>";
}

include '../../includes/kernel/post_modulation.php';

?>