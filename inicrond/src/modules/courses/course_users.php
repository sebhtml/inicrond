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


/*
    Administrateurs
        Groupe_name (count)
            Personnes

    Participants
        Group_name (count)
            Personnes

        Groupes en charge de ce groupe
            Groupe_name
                personnes
*/

if (isset ($_SESSION['usr_id']) && isset ($_GET['cours_id']) &&  (int) $_GET['cours_id']
&& is_in_charge_in_course ($_SESSION['usr_id'], $_GET['cours_id']))
{
    $CAN_ADMIN_STUDENTS_GRPS = /* teacher */ is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']);

    $big_array = array ();
    $big_array['administrators'] = array ();
    $big_array['students'] = array ();

    if (is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))//teacher
    {
        $course["stu_grps"] = retournerHref (__INICROND_INCLUDE_PATH__."modules/courses/grps.php?cours_id=".$_GET['cours_id'], $_LANG['modify']);       //groupes -> cours
    }

    if (($_SESSION['SUID']))    //if he /she is superuser.
    {
        //show the change teachers button.
        //groupes -> cours
        $course["admin_grps"] = retournerHref ("grps_for_ensei.b.php?cours_id=".$_GET['cours_id'], $_LANG['modify']);
    }

    //admins
    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id,
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    cours_id=".$_GET['cours_id']."
    AND
    is_teacher_group='1'
    ";

    $i = 0;

    $rs = $inicrond_db->Execute ($query);

    while ($fetch_result = $rs->FetchRow ())
    {
        $big_array['administrators'][$i]['group_name'] = $fetch_result['group_name'];

        $big_array['administrators'][$i]["group_link"] = __INICROND_INCLUDE_PATH__."modules/groups/grp.php?group_id=".$fetch_result['group_id'];

        $big_array['administrators'][$i]["edit_link"] = "<a href=\"".__INICROND_INCLUDE_PATH__."modules/groups/edit_a_group.php?group_id=".
            $fetch_result['group_id']."\">".$_LANG['edit']."</a>";

        $big_array['administrators'][$i]["users"] = array ();
        $j = 0;

        $query = "
        SELECT
        usr_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
        usr_nom,
        usr_prenom
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$fetch_result['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
        ORDER BY usr_nom ASC
        ";

        $rs2 = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs2->FetchRow ())
        {
            $big_array['administrators'][$i]["users"][$j]['usr_name'] = $fetch_result['usr_name'];
            $big_array['administrators'][$i]["users"][$j]['usr_nom'] = $fetch_result['usr_nom'];
            $big_array['administrators'][$i]["users"][$j]['usr_prenom'] = $fetch_result['usr_prenom'];
            $big_array['administrators'][$i]["users"][$j]["usr_link"] = __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".
                $fetch_result['usr_id']."&cours_id=".$_GET['cours_id'];

            $j++;
        }
        $i++;
    }

    //students
    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id,
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    cours_id=".$_GET['cours_id']."
    AND
    is_student_group = '1'
    ";

    $i = 0;

    $rs = $inicrond_db->Execute ($query);

    while ($fetch_result = $rs->FetchRow ())
    {
        $course_group_id = $fetch_result['group_id'];

        if ($CAN_ADMIN_STUDENTS_GRPS)
        {
            $big_array['students'][$i]["change_charge_link"] = __INICROND_INCLUDE_PATH__."modules/courses/groups_in_charge_for_course_group.php?group_id=".
                $fetch_result['group_id'];
        }

        $big_array['students'][$i]['group_name'] = "<a href=".__INICROND_INCLUDE_PATH__."modules/groups/grp.php?group_id=".$fetch_result['group_id'].">".
            $fetch_result['group_name']."</a>";

        $big_array['students'][$i]["edit_group_link"] = "<a href=".__INICROND_INCLUDE_PATH__."modules/groups/edit_a_group.php?group_id=".
            $fetch_result['group_id'].">".$_LANG['edit']."</a>";

        $big_array['students'][$i]["users"] = array ();

        $j = 0;

        $query = "
        SELECT
        usr_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
        usr_nom,
        usr_prenom
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=$course_group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
        ORDER BY usr_nom ASC
        ";

        $rs2 = $inicrond_db->Execute ($query);

        $count = 0;

        while ($fetch_result = $rs2->FetchRow ())
        {
            $count++;
            $big_array['students'][$i]["users"][$j]['usr_name'] = $fetch_result['usr_name'];
            $big_array['students'][$i]["users"][$j]['usr_nom'] = $fetch_result['usr_nom'];
            $big_array['students'][$i]["users"][$j]['usr_prenom'] = $fetch_result['usr_prenom'];
            $big_array['students'][$i]["users"][$j]["usr_link"] = __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id']."&cours_id=".$_GET['cours_id'];
            $j++;
        }

        $big_array['students'][$i]["count_users"] = $count;

        //get all the groups in charge

        $query = "
        SELECT
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id,
        group_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_id=$course_group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
        ";

        $k = 0;

        $rs3 = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs3->FetchRow ())
        {
            $big_array['students'][$i]['groups_in_charge'][$k]['group_name'] =
                "<a href=".__INICROND_INCLUDE_PATH__."modules/groups/grp.php?group_id=".$fetch_result['group_id'].">".$fetch_result['group_name']."</a>";

            $big_array['students'][$i]['groups_in_charge'][$k]["edit_group_link"] =
                "<a href=".__INICROND_INCLUDE_PATH__."modules/groups/edit_a_group.php?group_id=".$fetch_result['group_id'].">".$_LANG['edit']."</a>";

            $big_array['students'][$i]['groups_in_charge'][$k]["users"] = array ();

            $j = 0;

            $query = "
            SELECT
            usr_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
            usr_nom,
            usr_prenom
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$fetch_result['group_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
            ORDER BY usr_nom ASC
            ";

            $rs2 = $inicrond_db->Execute ($query);

            while ($fetch_result = $rs2->FetchRow ())
            {
                $big_array['students'][$i]['groups_in_charge'][$k]["users"][$j]['usr_name'] = $fetch_result['usr_name'];
                $big_array['students'][$i]['groups_in_charge'][$k]["users"][$j]['usr_nom'] = $fetch_result['usr_nom'];
                $big_array['students'][$i]['groups_in_charge'][$k]["users"][$j]['usr_prenom'] = $fetch_result['usr_prenom'];
                $big_array['students'][$i]['groups_in_charge'][$k]["users"][$j]["usr_link"] =
                    __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id']."&cours_id=".$_GET['cours_id'];
                $j++;
            }

            $k++;
        }
        //end of group in charge.
        $i++;
    }

    //get the cours_name
    $query = "
    SELECT
    cours_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
    WHERE
    cours_id=".$_GET['cours_id']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $big_array['cours_name'] = $fetch_result['cours_name'];
    $module_title = $_LANG['course_users'];
    $smarty->assign ('course', $course);
    $smarty->assign ("big_array", $big_array);
    $smarty->assign ("_LANG", $_LANG);

    //echo nl2br(print_r($big_array,true)); exit;

    $course_infos = get_cours_infos ($_GET['cours_id']);
    $smarty->assign ('course_infos', $course_infos);
    $module_content .=
    $smarty->fetch ($_OPTIONS['theme']."/course_users.tpl");
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>