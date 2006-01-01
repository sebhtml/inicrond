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

define ('__INICROND_INCLUDED__', TRUE); //security
define ('__INICROND_INCLUDE_PATH__', '../../'); //path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php'; //init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';        //include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not require lang variables.

if (isset ($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && $_SESSION['SUID'])    //enlever un cours
{
    //-----------------------
    // titre
    //---------------------

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

    $module_title = $_LANG['remove'];

    $module_content .=  $fetch_result['cours_name'];

    if (isset ($_GET["ok"]))
    {
        /////////////
        //DELETE ALL FILE.

        $query = "
        SELECT
        md5_path
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            unlink (__INICROND_INCLUDE_PATH__."uploads/".$fetch_result["md5_path"]);
        }

        //////////////
        //delete all flashes.
        $query = "
        SELECT
        HEXA_TAG
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);
        while ($fetch_result = $rs->FetchRow ())
        {
            unlink (__INICROND_INCLUDE_PATH__."uploads/".$fetch_result["HEXA_TAG"]);
        }

        ///////////////////
        //delete all images.
        $query = "
        SELECT
        img_hexa_path
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            unlink (__INICROND_INCLUDE_PATH__."uploads/".$fetch_result["img_hexa_path"]);
        }

        //get all questions
        $query = "
        SELECT
        question_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ";

        include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/drop_question.php";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            drop_question ($fetch_result['question_id']);
        }

        //get all tests.
        $query = "
        SELECT
        test_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id =  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/delete_test.php";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            delete_test ($fetch_result['test_id']);
        }

        //get all forum sections.

        $query = "
        SELECT
        forum_section_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())        //get all forum section.
        {
            $query = "
            SELECT
            forum_discussion_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            WHERE
            forum_section_id=".$fetch_result["forum_section_id"]."
            ";

            $rs2 = $inicrond_db->Execute ($query);

            while ($fetch_result2 = $rs2->FetchRow ())  //get all forums.
            {
                $query = "
                SELECT
                forum_sujet_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                forum_discussion_id=".$fetch_result2["forum_discussion_id"]."
                ";

                $rs3 = $inicrond_db->Execute ($query);

                while ($fetch_result3 = $rs3->FetchRow ())      //get all threads
                {
                    $query = "
                    DELETE FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                    WHERE
                    forum_sujet_id=".$fetch_result3["forum_sujet_id"]."
                    ";

                    $inicrond_db->Execute ($query);

                    //delete those stuff.
                    $query = "
                    DELETE FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads']."
                    WHERE
                    forum_sujet_id=".$fetch_result3["forum_sujet_id"]."
                    ";

                    $inicrond_db->Execute ($query);
                }

                $query = "
                DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                forum_discussion_id=".$fetch_result2["forum_discussion_id"]."
                ";

                $inicrond_db->Execute ($query);
            }

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            WHERE
            forum_section_id=".$fetch_result["forum_section_id"]."
            ";

            $inicrond_db->Execute ($query);
        }

        //get all files.
        $query = "
        SELECT
        file_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
            WHERE
            file_id=".$fetch_result['file_id']."
            ";

            $inicrond_db->Execute ($query);
        }
        //get all flashes.

        $query = "
        SELECT
        chapitre_media_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id =  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
        and
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
            WHERE
            chapitre_media_id=".$fetch_result['chapitre_media_id']."
            ";

            $inicrond_db->Execute ($query);
        }

        //get all sessions.
        $query = "
        SELECT
        session_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ";

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['page_views']."
            WHERE
            session_id=".$fetch_result['session_id']."
            ";

            $inicrond_db->Execute ($query);
        }

        //get all groups.

        $query = "
        SELECT
        group_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ";

        //easy to remove... , with a group_id.
        $tables_to_look = array (
                                'evaluations',
                                'sections_groups_view',
                                'forums_groups_reply',
                                'forums_groups_view',
                                'groups_usrs',
                                'course_group_in_charge',
                                'sebhtml_moderators',
                                'inode_groups',
                                'forums_groups_start'
                                );

        $rs = $inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            //get all evaluations.
            $query = "
            SELECT
            ev_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
            WHERE
            group_id=".$fetch_result['group_id']."
            ";

            $rs2 = $inicrond_db->Execute ($query);

            while ($fetch_result2 = $rs2->FetchRow ())
            {
                $query = "
                DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
                WHERE
                ev_id=".$fetch_result2['ev_id']."
                ";

                $inicrond_db->Execute ($query);
            }

            foreach ($tables_to_look AS $table)
            {
                $query = "
                DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table]."
                WHERE
                group_id=".$fetch_result['group_id']."
                ";

                $inicrond_db->Execute ($query);
            }
        }


        $tables_to_look = array ('chapitre_media',
                                'inicrond_images',
                                'inicrond_texts',
                                'courses_files',
                                'tests') ;

        foreach ($tables_to_look AS $table)
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            and
            cours_id=".$_GET['cours_id']."
            ";

            $inicrond_db->Execute ($query);
        }

        //easy to remove...
        $tables_to_look = array (
                                'cours',
                                'groups',
                                'sebhtml_forum_sections',
                                'online_time',
                                'questions'
                                );

        foreach ($tables_to_look AS $table)
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table]."
            WHERE
            cours_id=".$_GET['cours_id']."
            ";

            $inicrond_db->Execute ($query);
        }

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";   //javascript redirection
        js_redir (__INICROND_INCLUDE_PATH__."modules/courses/courses.php");
    }
    else
    {
        $module_content .=  "<br /><br />";
        $module_content .=  retournerHref ("?&cours_id=".$_GET['cours_id']."&ok", $_LANG['remove_now']);        //enlever le group
    }
}

include __INICROND_INCLUDE_PATH__."includes/kernel/post_modulation.php";

?>
