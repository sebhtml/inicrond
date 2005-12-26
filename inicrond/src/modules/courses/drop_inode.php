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
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/access.fun.php";  //function for access...
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";    //function for access...

if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))
{
    if (!isset ($_GET["ok"]))   //show the form.
    {
        $module_content .=
        retournerHref (__INICROND_INCLUDE_PATH__. "modules/courses/drop_inode.php?inode_id=". $_GET['inode_id']."&ok", $_LANG['remove']);
    }
    else
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";   //javascript redirection
        //get the inode location

        /*
        We first have to find if it is a directory, flash, text, test, file
        */

        $relation_to_search_in = array ('virtual_directories', 'courses_files', 'tests', 'chapitre_media', 'inicrond_images', 'inicrond_texts') ;

        $relation_that_refer_to_the_current_inode = '' ;
        $the_row_have_been_found = false ;

        for ($i = 0 ; ($i <= 5) && $the_row_have_been_found == false ; $i ++)
        {
            $query = "
            select
            count (inode_id) as count_inode_id
            from
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$relation_to_search_in[$i]]."
            where
            inode_id = ".$_GET['inode_id']."
            " ;

            $rs = $inicrond_db->Execute ($query);

            $fetch_result = $rs->FetchRow ();

            if ($fetch_result['count_inode_id'] == 1)
            {
                $the_row_have_been_found = true ;
                $relation_that_refer_to_the_current_inode = $relation_to_search_in[$i] ;
            }
        }

        $query = "
        SELECT
        inode_id_location,
        cours_id,
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        inode_id=".$_GET['inode_id']."
        ";

        $rs = $inicrond_db->Execute ($query);
        $fetch_result = $rs->FetchRow ();

        $inode_id_location = $fetch_result['inode_id_location'];
        $cours_id = $fetch_result['cours_id'];

        if ($relation_that_refer_to_the_current_inode == 'virtual_directories')
        {
            //check if there is something in this directory...
            $query = "
            SELECT
            inode_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id_location=".$_GET['inode_id']."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result = $rs->FetchRow ();

            if (!isset ($fetch_result['inode_id']))     //the directory is empty, go...
            {
                $query = "
                DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                inode_id=".$_GET['inode_id']."";

                $inicrond_db->Execute ($query);

                $query = "
                DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']."
                WHERE
                inode_id=".$_GET['inode_id']."";

                $inicrond_db->Execute ($query);
            }
            else                //something has been found in this directory...
            {
                $module_content .=  $_LANG['this_directory_is_not_empty'];
            }
        }
        elseif ($relation_that_refer_to_the_current_inode == 'courses_files')
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id']."";

            $inicrond_db->Execute ($query);

            //delete the file on hard drive.
            $query = "
            SELECT
            md5_path
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
            WHERE
            inode_id=".$_GET["inode_id"]."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result2 = $rs->FetchRow ();

            unlink ($_OPTIONS["file_path"]["uploads"]. $fetch_result2["md5_path"]);

            //remove the actions for this file.
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
            using
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id = ".$_GET["inode_id"]."
            ";

            $inicrond_db->Execute ($query);

            //remove the entry in files.
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
            WHERE
            inode_id=".$_GET["inode_id"]."
            ";

            $inicrond_db->Execute ($query);
        }
        elseif ($relation_that_refer_to_the_current_inode == 'tests')
        {
             $query = "
            SELECT
            test_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
            WHERE
            inode_id=".$_GET["inode_id"]."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result = $rs->FetchRow ();

            include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/delete_test.php";

            delete_test ($fetch_result["test_id"]);

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id']."";

            $inicrond_db->Execute ($query);

        }
        elseif ($relation_that_refer_to_the_current_inode == 'chapitre_media')
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);
            //delete the file on hard drive.
            $query = "
            SELECT
            HEXA_TAG
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result2 = $rs->FetchRow ();

            unlink ($_OPTIONS["file_path"]["uploads"].$fetch_result2["HEXA_TAG"]);

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
            using
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".score_id
            and
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);
        }
        elseif ($relation_that_refer_to_the_current_inode == 'inicrond_images')
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);

            //delete the file on hard drive.
            $query = "
            SELECT
            img_hexa_path
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $rs = $inicrond_db->Execute ($query);
            $fetch_result2 = $rs->FetchRow ();

            unlink ($_OPTIONS["file_path"]["uploads"].$fetch_result2["img_hexa_path"]);

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);
        }
        elseif ($relation_that_refer_to_the_current_inode == 'inicrond_texts')
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);
            //delete the file on hard drive.

            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
            WHERE
            inode_id=".$_GET['inode_id']."
            ";

            $inicrond_db->Execute ($query);
        }

        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__. "modules/courses/inode.php?cours_id=".$cours_id.
        "&inode_id_location=".$inode_id_location."\">".$_LANG['return']. "</a>";
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>