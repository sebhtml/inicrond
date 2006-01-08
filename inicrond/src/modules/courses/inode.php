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

include __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/includes/languages/fr-ca/lang.php' ;

include "includes/functions/transfert_cours.function.php";      //transfer IDs
include "includes/functions/inode_full_path.php";       //transfer IDs

include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/format_file_size.php";    //transfer IDs
include __INICROND_INCLUDE_PATH__.
  'modules/members/includes/functions/access.inc.php';
include "includes/functions/is_in_inode_group.php";     //transfer IDs


if (isset ($_GET['inode_id_location']) && $_GET['inode_id_location'] != "" && (int) $_GET['inode_id_location'] && $_GET['inode_id_location'] != 0
    && is_in_inode_group ($_SESSION['usr_id'], $_GET['inode_id_location']))
{
    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=".$_GET['inode_id_location']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $inode_id_location = $_GET['inode_id_location'];
    $cours_id = $fetch_result['cours_id'];

    $ok = 1;
}
elseif (isset ($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_numeric ($_GET['cours_id']))
{
    $cours_id = $_GET['cours_id'];
    $inode_id_location = 0;
    $ok = 1;
}

if ($ok && $is_student_of_cours = is_student_of_cours ($_SESSION['usr_id'], $cours_id))
{
    $is_in_charge_in_course = is_in_charge_in_course ($_SESSION['usr_id'], $cours_id);

    $smarty->assign ('cours_id', $cours_id);

    $is_teacher_of_cours = is_teacher_of_cours ($_SESSION['usr_id'], $cours_id);

    /* cours_code */
    $query = "
    SELECT
    cours_name,
    cours_description
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
    WHERE
    cours_id=$cours_id
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $module_title = $fetch_result['cours_name'];

    if ($_OPTIONS['smarty_cache_config']['courses']["inode.tpl"] != 0)       // != 0
    {
        $smarty->caching = 1;
        $smarty->cache_lifetime =
        $_OPTIONS['smarty_cache_config']['courses']["inode.tpl"];
    }

    $cache_id = md5 ($_SESSION['language'].$cours_id.$is_teacher_of_cours.$_SESSION['SUID'].$inode_id_location);

    if (!$smarty->is_cached ($_OPTIONS['theme']."/inode.tpl", $cache_id))
    {
        $can_drop = $is_teacher_of_cours;
        $can_up = $is_teacher_of_cours;
        $can_down = $is_teacher_of_cours;

        //-----------------------
        // titre
        //---------------------
        $cours_name = $fetch_result['cours_name'];

        if (isset($_GET['inode_id_location']))
        {
            $smarty->assign ('requested_path', inode_full_path ($_GET['inode_id_location'], $cours_id));
        }

        //get the parent dir...
        if (isset ($_GET['inode_id_location']) && $_GET['inode_id_location'] != 0)
        {
            $query = "
            SELECT
            inode_id_location
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id_location']."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result = $rs->FetchRow ();

            if ($fetch_result['inode_id_location'])     // != 0
            {
                $smarty->assign ("parent_dir", __INICROND_INCLUDE_PATH__."modules/courses/inode.php?&inode_id_location=".$fetch_result['inode_id_location']);
            }
            else
            {
                $smarty->assign ("parent_dir",__INICROND_INCLUDE_PATH__."modules/courses/inode.php?&cours_id=$cours_id");
            }
        }
        else                    //all the link for this course hehe.
        {
            $course["forums_link"] = __INICROND_INCLUDE_PATH__. "modules/mod_forum/main_inc.php?&cours_id=".$_GET['cours_id'];

            $course['cours_description'] = BBcode_parser ($fetch_result['cours_description']);

            if ($is_in_charge_in_course)
            {
                $course['see_online_people_for_a_course'] =
                    retournerHref (__INICROND_INCLUDE_PATH__."modules/seSSi/see_online_people_for_a_course.php?cours_id=".$_GET['cours_id']."", $_LANG['see_online_people_for_a_course']);

                $course['inicrond_x_module'] =
                    "<a href=\"".__INICROND_INCLUDE_PATH__."modules/inicrond_x/inicrond_x_groups_selection.php?&cours_id=$cours_id\">".$_LANG['inicrond_x_module']."</a>";
            }
        }

        //dirs

        /* check the requested inode. */
        if (isset ($_GET['inode_id_location']) && $_GET['inode_id_location'] != "" && (int) $_GET['inode_id_location'])
        {
            $inode_id_location = $_GET['inode_id_location'] ;
        }
        else
        {
            $inode_id_location = 0 ;
        }

        if ($is_teacher_of_cours)
        {
            $smarty->assign ('add_dir', __INICROND_INCLUDE_PATH__."modules/courses/add_dir.php?inode_id_location=".$inode_id_location."&cours_id=".$cours_id."");
        }

        $is_teacher_of_cours_numeric = $is_teacher_of_cours ? 1 : 0;

        if ($is_teacher_of_cours)       //the teacher query.
        {
            //dir list

            $query = "
            SELECT
            T1.inode_id,
            dir_name,
            order_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
            WHERE
            cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            T1.inode_id = T2.inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query
        {
            $query = "
            SELECT
            DISTINCT
            T1.inode_id AS inode_id,
            order_id,
            dir_name
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
            WHERE
            cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = T1.inode_id
            AND
            T1.inode_id = T2.inode_id
            ORDER BY order_id ASC
            ";
        }

        $dirs_list = array ();

        $can_edit_dir = $is_teacher_of_cours;

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $dir = array ();
            $dir["order_id"] = $fetch_result["order_id"];
            $dir['inode_id'] = $fetch_result['inode_id'];
            $dir["link"] = retournerHref (__INICROND_INCLUDE_PATH__.
                                       "modules/courses/inode.php?inode_id_location=".$fetch_result['inode_id']."", $fetch_result["dir_name"]);

            if ($can_edit_dir)
            {
                $dir['edit'] = __INICROND_INCLUDE_PATH__."modules/courses/edit_dir.php?inode_id=".$fetch_result['inode_id']."";
            }

            if ($can_up)
            {
                $dir['inode_up'] =__INICROND_INCLUDE_PATH__."modules/courses/inode_up.php?inode_id=".$fetch_result['inode_id']."";
            }
            if ($can_down)
            {
                $dir['inode_down'] =__INICROND_INCLUDE_PATH__."modules/courses/inode_down.php?inode_id=".$fetch_result['inode_id']."";
            }

            if ($can_drop)
            {
                $dir['drop'] = __INICROND_INCLUDE_PATH__."modules/courses/drop_inode.php?inode_id=".$fetch_result['inode_id']."";
            }

            $dirs_list[] = $dir;
        }

        /* Files */
        if ($is_teacher_of_cours)       //the teacher query.
        {
            $query = "
            SELECT
            file_id,
            file_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id as inode_id,
            file_infos,
            file_title,
            filesize,
            md5_sum,
            add_gmt,
            edit_gmt
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query
        {
            $query = "
            SELECT DISTINCT
            file_id,
            file_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            file_infos,
            file_title,
            filesize,
            md5_sum,
            add_gmt,
            edit_gmt
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
            ";
        }

        $mod_files = array ();

        if ($is_teacher_of_cours)
        {
            $smarty->assign ('add_file',
                __INICROND_INCLUDE_PATH__."modules/files_4_courses/add_edit_file.modu.php?inode_id_location=$inode_id_location&cours_id=$cours_id");
        }
        $rs = $inicrond_db->Execute ($query);

        if ($is_in_charge_in_course)
        {
            $dl_acts = TRUE;
        }
        if ($is_in_charge_in_course)    ///view the download for the file.
        {
            $dl_report = TRUE;
        }

        $can_edit_file = $is_teacher_of_cours;

        while ($fetch_result = $rs->FetchRow ())
        {
            $file = array ();

            $file["my_results_link"] = '<a href="'.__INICROND_INCLUDE_PATH__. "modules/dl_acts_4_courses/show_dl_acts.mo.php?file_id=".
                $fetch_result['file_id']."&usr_id=".$_SESSION['usr_id']."&join".'">'.$_LANG['dl_acts_4_courses'].'</a>';

            $file['inode_id'] = $fetch_result['inode_id'];

            $file["link"] =
                retournerHref (__INICROND_INCLUDE_PATH__."modules/files_4_courses/download.php?file_id=".$fetch_result['file_id']."",$fetch_result['file_title']);

            $file["file_infos"] = BBcode_parser ($fetch_result["file_infos"]);
            $file['file_name'] = $fetch_result['file_name'];
            $file['md5_sum'] = $fetch_result['md5_sum'];
            $file['filesize'] = format_file_size ($fetch_result['filesize']);
            $file['add_gmt'] = format_time_stamp ($fetch_result['add_gmt']);
            $file['edit_gmt'] = format_time_stamp ($fetch_result['edit_gmt']);

            if ($can_up)
            {
                $file['inode_up'] = __INICROND_INCLUDE_PATH__."modules/courses/inode_up.php?inode_id=".$fetch_result['inode_id']."";
            }
            if ($can_down)
            {
                $file['inode_down'] =__INICROND_INCLUDE_PATH__."modules/courses/inode_down.php?inode_id=".$fetch_result['inode_id']."";
            }

            if ($can_edit_file)
            {
                $file['edit'] =__INICROND_INCLUDE_PATH__."modules/files_4_courses/add_edit_file.modu.php?file_id=".$fetch_result['file_id']."";
            }

            if ($can_drop)
            {
                $file['drop'] =__INICROND_INCLUDE_PATH__."modules/courses/drop_inode.php?inode_id=".$fetch_result['inode_id']."";
            }

            if (isset ($dl_acts) && $dl_acts)
            {
                $file["dl_acts"] =__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?file_id=".$fetch_result['file_id']."";
            }

            if (isset ($dl_report) && $dl_report)
            {
                $file["dl_report"] =__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/group_downloads_reporting.php?file_id=".$fetch_result['file_id']."";
            }

            $mod_files[] = $file;
        }

        //tests

        if ($is_teacher_of_cours)
        {
            $smarty->assign ('add_test',
                            __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/add_test.php?inode_id_location=".$inode_id_location."&cours_id=".$cours_id."");
        }

        if ($is_teacher_of_cours)       //the teacher query
        {
            $query = "
            SELECT
            test_id,
            test_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            time_GMT_add,
            time_GMT_edit,
            test_info
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query.
        {
            $query = "
            SELECT DISTINCT
            test_id,
            test_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            time_GMT_add,
            time_GMT_edit,
            test_info
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
                        ";
        }

        $tests = array ();

        if ($is_teacher_of_cours)
        {
            $edit_test = TRUE;
        }
        else
        {
            $edit_test = FALSE;
        }

        if ($is_in_charge_in_course)
        {
            $show_scores = TRUE;
        }

        if ($is_teacher_of_cours)
        {
            $mass_update = TRUE;
        }

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $test = array ();
            $test['inode_id'] = $fetch_result['inode_id'];

            $test["my_results_link"] =
            __INICROND_INCLUDE_PATH__."modules/tests-results/results.php?usr_id=".$_SESSION['usr_id']."&test_id=".$fetch_result['test_id']."&join";

            $test["link"] =
            retournerHref (__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/do_it.php?test_id=".$fetch_result['test_id']."", $fetch_result['test_name']);

            $test["time_GMT_add"] = format_time_stamp ($fetch_result["time_GMT_add"]);

            $test["time_GMT_edit"] = format_time_stamp ($fetch_result["time_GMT_edit"]);

            $test['test_info'] = BBcode_parser ($fetch_result['test_info']);

            if ($is_teacher_of_cours)
            {
                $test['inode_up'] = __INICROND_INCLUDE_PATH__."modules/courses/inode_up.php?inode_id=".$fetch_result['inode_id']."";
                $test['inode_down'] =__INICROND_INCLUDE_PATH__."modules/courses/inode_down.php?inode_id=".$fetch_result['inode_id']."";
                $test['edit'] =__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/edit.php?test_id=".$fetch_result['test_id'];
                $test['edit_a_test_GOLD'] =__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/edit_a_test_GOLD.php?test_id=".$fetch_result['test_id'];
                $test['drop'] =__INICROND_INCLUDE_PATH__."modules/courses/drop_inode.php?inode_id=".$fetch_result['inode_id']."";
                $test["mass_update"] =__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/update_test_results.php?test_id=".$fetch_result['test_id']."";
            }

            if ($is_in_charge_in_course)
            {
                $test['scores'] =__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?test_id=".$fetch_result['test_id']."";
                $test["report"] =__INICROND_INCLUDE_PATH__."modules/tests-results/test_activities_report.php?&test_id=".$fetch_result['test_id'];
            }

            $tests[] = $test;
        }

        //animations

        if ($is_teacher_of_cours)
        {
            $smarty->assign ('add_swf',
                            __INICROND_INCLUDE_PATH__."modules/course_media/add_flash.php?inode_id_location=".$inode_id_location."&cours_id=".$cours_id);

            $smarty->assign ('add_img',
                            __INICROND_INCLUDE_PATH__."modules/course_media/add_img.php?inode_id_location=".$inode_id_location."&cours_id=".$cours_id);

            $smarty->assign ('add_text',
                            __INICROND_INCLUDE_PATH__."modules/course_media/add_text.php?inode_id_location=".$inode_id_location."&cours_id=".$cours_id);
        }

        //swf s
        if ($is_teacher_of_cours)       //the teacher query.
        {
            $query = "
            SELECT
            chapitre_media_id,
            chapitre_media_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id as inode_id,
            file_name,
            chapitre_media_edit_gmt_timestamp,
            chapitre_media_add_gmt_timestamp,
            chapitre_media_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query.
        {
            $query = "
            SELECT DISTINCT
            chapitre_media_id,
            chapitre_media_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            file_name,
            chapitre_media_edit_gmt_timestamp,
            chapitre_media_add_gmt_timestamp,
            chapitre_media_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
            ";
        }

        $anims = array ();

        if ($is_teacher_of_cours)
        {
            $edit_swf = TRUE;
        }

        if ($is_in_charge_in_course)
        {
            $show_marks = TRUE;
        }

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $anim = array ();

            $anim["my_results_link"] =
                __INICROND_INCLUDE_PATH__."modules/marks/main.php?usr_id=". $_SESSION['usr_id']."&chapitre_media_id=".$fetch_result['chapitre_media_id']."&join";

            $anim['inode_id'] = $fetch_result['inode_id'];

            $anim['file_name'] = $fetch_result['file_name'];
            $anim['chapitre_media_edit_gmt_timestamp'] =format_time_stamp ($fetch_result['chapitre_media_edit_gmt_timestamp']);
            $anim['chapitre_media_description'] =BBcode_parser ($fetch_result['chapitre_media_description']);
            $anim['chapitre_media_add_gmt_timestamp'] =format_time_stamp ($fetch_result['chapitre_media_add_gmt_timestamp']);

            if (isset ($question_ordering_id))
            {
               $anim["link"] =retournerHref ("javascript:popup('".__INICROND_INCLUDE_PATH__."modules/course_media/flash.php?chapitre_media_id=".
                $fetch_result['chapitre_media_id']."&question_ordering_id=".$question_ordering_id."', 790, 590)", $fetch_result['chapitre_media_title']) ;
            }
            else
            {
                $anim["link"] =retournerHref ("javascript:popup('".__INICROND_INCLUDE_PATH__."modules/course_media/flash.php?chapitre_media_id=".
                $fetch_result['chapitre_media_id']."', 790, 590)", $fetch_result['chapitre_media_title']) ;
            }

            if ($is_teacher_of_cours)
            {
                $anim['inode_up'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_up.php?inode_id=". $fetch_result['inode_id']."";
                $anim['inode_down'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_down.php?inode_id=". $fetch_result['inode_id']."";
                $anim['edit'] = __INICROND_INCLUDE_PATH__. "modules/course_media/edit_flash.php?chapitre_media_id=". $fetch_result['chapitre_media_id'];
                $anim['drop'] = __INICROND_INCLUDE_PATH__. "modules/courses/drop_inode.php?inode_id=". $fetch_result['inode_id']."";
            }

            if ($is_in_charge_in_course)
            {
                $anim['marks'] = __INICROND_INCLUDE_PATH__. "modules/marks/main.php?chapitre_media_id=". $fetch_result['chapitre_media_id']."";
                $anim["report"] = __INICROND_INCLUDE_PATH__. "modules/marks/flash_activities_report.php?&chapitre_media_id=".$fetch_result['chapitre_media_id'];
            }

            $anims[] = $anim;
        }

        //images

        if ($is_teacher_of_cours)       //the teacher query.
        {
            $query = "
            SELECT
            img_id,
            img_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id as inode_id,
            img_file_name,
            add_time_t,
            edit_time_t,
            img_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query
        {
            $query = "
            SELECT DISTINCT
            img_id,
            img_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            img_file_name,
            add_time_t,
            edit_time_t,
            img_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        $images = array ();

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $anim = array ();
            $anim['inode_id'] = $fetch_result['inode_id'];
            $anim["img_url"] = __INICROND_INCLUDE_PATH__. "modules/course_media/download_img.php?img_id=". $fetch_result["img_id"];

            $anim['title'] = $fetch_result['img_title'];

            $anim['file_name'] = $fetch_result['img_file_name'];
            $anim['chapitre_media_edit_gmt_timestamp'] = format_time_stamp ($fetch_result["edit_time_t"]);
            $anim['chapitre_media_description'] = nl2br ($fetch_result['img_description']);
            $anim['chapitre_media_add_gmt_timestamp'] = format_time_stamp ($fetch_result["add_time_t"]);

            if (isset ($can_up) && $can_up)
            {
                $anim['inode_up'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_up.php?inode_id=". $fetch_result['inode_id']."";
            }
            if (isset ($can_down) && $can_down)
            {
                $anim['inode_down'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_down.php?inode_id=". $fetch_result['inode_id']."";
            }

            if (isset ($edit_swf) && $edit_swf)
            {
                $anim['edit'] = __INICROND_INCLUDE_PATH__. "modules/course_media/edit_image.php?img_id=". $fetch_result["img_id"];
            }
            if (isset ($can_drop) && $can_drop)
            {
                $anim['drop'] = __INICROND_INCLUDE_PATH__. "modules/courses/drop_inode.php?inode_id=". $fetch_result['inode_id']."";
            }

            $images[] = $anim;
        }

        /*
            Texts
        */

        if ($is_teacher_of_cours)       //the teacher query.
        {
            //text
            $query = "
            SELECT
            text_id,
            text_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id as inode_id,
            add_time_t,
            edit_time_t,
            text_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query
        {
            $query = "
            SELECT DISTINCT
            text_id,
            text_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            add_time_t,
            edit_time_t,
            text_description
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
            ";
        }

        $texts = array ();

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $anim = array ();
            $anim['inode_id'] = $fetch_result['inode_id'];
            $anim['title'] = $fetch_result['text_title'];
            $anim['chapitre_media_edit_gmt_timestamp'] = format_time_stamp ($fetch_result["edit_time_t"]);
            $anim['chapitre_media_description'] = nl2br ($fetch_result['text_description']);
            $anim['chapitre_media_add_gmt_timestamp'] = format_time_stamp ($fetch_result["add_time_t"]);

            if ($can_up)
            {
                $anim['inode_up'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_up.php?inode_id=". $fetch_result['inode_id']."";
            }
            if ($can_down)
            {
                $anim['inode_down'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_down.php?inode_id=". $fetch_result['inode_id']."";
            }
            if ($edit_swf)
            {
                $anim['edit'] = __INICROND_INCLUDE_PATH__. "modules/course_media/edit_text.php?text_id=". $fetch_result["text_id"];
            }
            if ($can_drop)
            {
                $anim['drop'] = __INICROND_INCLUDE_PATH__. "modules/courses/drop_inode.php?inode_id=". $fetch_result['inode_id']."";
            }

            $texts[] = $anim;
        }


        /*
            java_identifications_on_a_figure
        */

        if ($is_teacher_of_cours)       //the teacher query.
        {

            $smarty->assign ('add_a_java_identifications_on_a_figure', __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/add_a_java_identifications_on_a_figure.php?cours_id='.$cours_id.'&inode_id_location='.$inode_id_location) ;

            //text
            $query = "
            SELECT
            title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id as inode_id,
            add_time_t,
            edit_time_t,
            image_file_name
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['java_identifications_on_a_figure']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['java_identifications_on_a_figure'].".inode_id
            ORDER BY order_id ASC
            ";
        }
        else                    //the student query
        {
            $query = "
            SELECT DISTINCT
            title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id AS inode_id,
            add_time_t,
            edit_time_t,
            image_file_name
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['java_identifications_on_a_figure'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
            AND
            inode_id_location=$inode_id_location
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['java_identifications_on_a_figure'].".inode_id
            AND
            usr_id = ".$_SESSION['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ORDER BY order_id ASC
            ";
        }

        $java_identifications_on_a_figure = array () ;

        $rs_for_java_identifications_on_a_figure = $inicrond_db->Execute ($query) ;

        while ($fetch_result = $rs_for_java_identifications_on_a_figure->FetchRow ())
        {
            /*
                inode_id
                title
                add_time_t
                edit_time_t
                inode_up
                inode_down
                edit
                drop
            */

            $this_item = array ();
            $this_item['inode_id'] = $fetch_result['inode_id'];
            $this_item['image_file_name'] = $fetch_result['image_file_name'];
            $this_item['title'] = $fetch_result['title'];
            $this_item['add_time_t'] = format_time_stamp ($fetch_result["add_time_t"]);
            $this_item['edit_time_t'] = format_time_stamp ($fetch_result["edit_time_t"]);

            /*
                get_xml_informations_for_a_java_identifications_on_a_figure [done]
                list_java_identifications_on_a_figure_result
                try_a_java_identifications_on_a_figure
                my_results
            */

            $this_item['try_a_java_identifications_on_a_figure'] = __INICROND_INCLUDE_PATH__. "modules/java_identifications_on_a_figure/try_a_java_identifications_on_a_figure.php?inode_id=". $fetch_result["inode_id"] ;

            if ($is_teacher_of_cours)
            {

                $this_item['get_xml_informations_for_a_java_identifications_on_a_figure'] = __INICROND_INCLUDE_PATH__. "modules/java_identifications_on_a_figure/get_xml_informations_for_a_java_identifications_on_a_figure.php?inode_id=". $fetch_result["inode_id"] ;

                $this_item['list_java_identifications_on_a_figure_result'] = __INICROND_INCLUDE_PATH__. "modules/java_identifications_on_a_figure/list_java_identifications_on_a_figure_result.php?inode_id=". $fetch_result["inode_id"] ;

                $this_item['inode_up'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_up.php?inode_id=". $fetch_result['inode_id']."";

                $this_item['inode_down'] = __INICROND_INCLUDE_PATH__. "modules/courses/inode_down.php?inode_id=". $fetch_result['inode_id']."";

                $this_item['edit'] = __INICROND_INCLUDE_PATH__. "modules/java_identifications_on_a_figure/edit_a_java_identifications_on_a_figure.php?inode_id=". $fetch_result["inode_id"];

                $this_item['drop'] = __INICROND_INCLUDE_PATH__. "modules/courses/drop_inode.php?inode_id=". $fetch_result['inode_id']."";
            }

            if ($is_in_charge_in_course)
            {
                $this_item['list_java_identifications_on_a_figure_result'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/list_java_identifications_on_a_figure_result.php?inode_id='.$fetch_result['inode_id'].'' ;

                $this_item['activities_report_for_a_java_identifications_on_a_figure'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/activities_report_for_a_java_identifications_on_a_figure.php?inode_id='.$fetch_result['inode_id'].'' ;
            }

            $this_item['list_java_identifications_on_a_figure_result_with_user_id'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/list_java_identifications_on_a_figure_result.php?inode_id='.$fetch_result['inode_id'].'&usr_id='.$_SESSION['usr_id'].'' ;

            $this_item['get_java_identifications_on_a_figure_image'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/get_java_identifications_on_a_figure_image.php?inode_id='.$fetch_result['inode_id'] ;

            $this_item['get_xml_informations_for_a_java_identifications_on_a_figure'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/get_xml_informations_for_a_java_identifications_on_a_figure.php?inode_id='.$fetch_result['inode_id'] ;

            $this_item['try_a_java_identifications_on_a_figure'] = __INICROND_INCLUDE_PATH__.'modules/java_identifications_on_a_figure/try_a_java_identifications_on_a_figure.php?inode_id='.$fetch_result['inode_id'] ;


            $java_identifications_on_a_figure[] = $this_item;
        }

        $smarty->assign ('java_identifications_on_a_figure', $java_identifications_on_a_figure) ;

        /*
            end of java_identifications_on_a_figure
        */

        if (!isset ($_GET['inode_id_location']) || $_GET['inode_id_location'] == 0)        //show those thing only for inode 0
        {

            if ($_SESSION['SUID'])//enlever
            {
                $course['drop'] = retournerHref (__INICROND_INCLUDE_PATH__."modules/courses/remove_course.php?cours_id=".$_GET['cours_id']."", $_LANG['remove']);
            }

            if ($is_teacher_of_cours)
            {
                $course['edit'] = retournerHref (__INICROND_INCLUDE_PATH__. "modules/courses/add_edit_course.php?cours_id=". $_GET['cours_id'], $_LANG['edit']);

                $smarty->assign ('course_groups_listing', "<a href=\"".__INICROND_INCLUDE_PATH__. "modules/groups/course_groups_listing.php?cours_id=". $cours_id."\">".
                                    $_LANG['course_groups_listing']."</a>");
            }
        }

        if ($is_teacher_of_cours)
        {
            $smarty->assign ('course_admin_menu', "<a href=\"".__INICROND_INCLUDE_PATH__."modules/course_admin/course_admin_menu.php?cours_id=$cours_id\">".
                            $_LANG['course_admin_menu']."</a>");
        }

        $course_infos = get_cours_infos ($cours_id);

        $smarty->assign ('course_infos', $course_infos);

        $smarty->assign ('_LANG', $_LANG);
        $smarty->assign ('dirs_list', $dirs_list);
        $smarty->assign ('images', $images);
        $smarty->assign ('texts', $texts);
        $smarty->assign ('mod_files', $mod_files);

        if (isset ($_GET['cours_id']))
        {
        $smarty->assign ('blue_master_clone', "<a href=\"".__INICROND_INCLUDE_PATH__. "modules/blue_master_clone/blue_master_clone.php?cours_id=".
                        $_GET['cours_id']."\">".$_LANG['blue_master_clone']. "</a>");
        }

        $smarty->assign ('tests', $tests);
        $smarty->assign ('anims', $anims);

        if (is_in_charge_in_course ($_SESSION['usr_id'], $cours_id))
        {
            $smarty->assign ('course_users', retournerHref (__INICROND_INCLUDE_PATH__. "modules/courses/course_users.php?cours_id=". $_GET['cours_id']."",
             $_LANG['course_users']));
        }

        $smarty->assign ('calendar', "<a href=\"".__INICROND_INCLUDE_PATH__. "modules/calendar/main_inc.php?&cours_id=$cours_id\">". $_LANG['calendar']."</a>");

        if (isset ($course))
        {
            $smarty->assign ('course', $course);
        }
    }

    $module_content = $smarty->fetch ($_OPTIONS['theme']."/inode.tpl", $cache_id);
    $smarty->caching = 0;

    $extra_js =
    "<script type=\"text/javascript\" src=\"".__INICROND_INCLUDE_PATH__.
    "modules/courses/templates/inicrond_default/javascripts/popup.js\"></script>    ";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>