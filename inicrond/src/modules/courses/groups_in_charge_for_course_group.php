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

define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";

if (isset ($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id'] && $cours_id = group_id_to_cours_id ($_GET['group_id'])
    && is_teacher_of_cours ($_SESSION['usr_id'], $cours_id))
{
    $module_title = $_LANG['groups_in_charge_for_course_group'];

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

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    foreach ($fetch_result AS $key = >$value)
    {
        $module_content .=  $_LANG[$key]." : ".$value."<br />";
    }

    $module_content .=  "<br /><br />";

    if (isset ($_POST["data_sent"]))
    {
        //echo "update stuff";
        //remove all groups participants.

        $query = "
        DELETE
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
        WHERE
        group_id=".$_GET['group_id']."
        ";

        $inicrond_db->Execute ($query);

        foreach ($_POST AS $key = >$value)
        {
            if (preg_match ("/group_in_charge_group_id=(.+)/", $key, $tokens))
            //les txt pour les answer.
            {
                $query = "
                INSERT INTO
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
                (group_id, group_in_charge_group_id)
                VALUES
                (".$_GET['group_id'].", ".$tokens["1"].")
                ";

            $inicrond_db->Execute ($query);
            }
        }
    }

    $module_content .=  "<form method=\"POST\">";

    //here list all group in this course except the current group.

    $tab = array (array ($_LANG['group_name'], $_LANG['checkbox']));

    $query = "
    SELECT
    group_id,
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    cours_id=$cours_id
    AND
    group_id != ".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute ($query);

    while ($fetch_result = $rs->FetchRow ())    //foreach group, check if the group is in charge of the current group.
    {
        $query = "
        SELECT
        group_in_charge_group_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
        WHERE
        group_in_charge_group_id=".$fetch_result['group_id']."
        AND
        group_id = ".$_GET['group_id']."
        ";

        $rs2 = $inicrond_db->Execute ($query);
        $fetch_result2 = $rs2->FetchRow ();

        $checked = isset ($fetch_result2["group_in_charge_group_id"]) ? "CHECKED" : "";

        $tab[] = array ($fetch_result['group_name'], " <input $checked type=\"checkbox\" name=\"group_in_charge_group_id=".$fetch_result['group_id'].
            "\" value=\"\" />");
    }

    $module_content .=  retournerTableauXY ($tab);

    $module_content .=  "<input  type=\"submit\" name=\"data_sent\" /> </form><h2><a href=\"course_users.php?&cours_id=$cours_id\">".
        $_LANG['course_users']."</a></h2>";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>