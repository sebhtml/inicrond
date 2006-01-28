<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

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

include 'includes/constants/list_lost_inodes.php' ;

include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_id_to_table_content_name.php' ;

include 'includes/functions/list_lost_inodes_lost_chapitre_media.php' ;
include 'includes/functions/list_lost_inodes_lost_courses_files.php' ;
include 'includes/functions/list_lost_inodes_lost_inicrond_images.php' ;
include 'includes/functions/list_lost_inodes_lost_inicrond_texts.php' ;
include 'includes/functions/list_lost_inodes_lost_java_identifications_on_a_figure.php' ;
include 'includes/functions/list_lost_inodes_lost_tests.php' ;
include 'includes/functions/list_lost_inodes_lost_virtual_directories.php' ;

if ($_SESSION['SUID'])
{
    // get all courses

    $course = array () ;

    $query = '
    select
    cours_id,
    cours_name,
    cours_code
    from
    '.$_OPTIONS["table_prefix"].'cours
    ' ;

    $results_set_for_courses = $inicrond_db->Execute ($query) ;

    $course_id = 0 ;

    while ($row = $results_set_for_courses->fetchRow ())
    {

        /*
            inode -> un parmi {section, fichier, examen formatif, animation, image, texte, java application}

            section -> inode
            fichier -> inode
            examen formatif -> inode
            animation -> inode
            image -> inode
            texte -> inode
            java applications -> inode
        */

        $course[$course_id]['cours_id'] = $row['cours_id'] ;
        $course[$course_id]['cours_name'] = $row['cours_name'] ;
        $course[$course_id]['cours_code'] = $row['cours_code'] ;

        //get all inodes
        $query = '
        select
        inode_id
        from
        '.$_OPTIONS["table_prefix"].'inode_elements
        where
        cours_id = '.$row['cours_id'].'
        ' ;

        $results_set_for_inodes = $inicrond_db->Execute ($query) ;

        $course[$course_id]['lost_inode'] = array () ;

        $lost_inode_id = 0 ;

        while ($row = $results_set_for_inodes->fetchRow ()) // foreach inode, check if it is lost...
        {
            $inode_id = $row['inode_id'] ;

            $relation = inode_id_to_table_content_name ($inode_id, $inicrond_db, $_OPTIONS) ;

            if ($relation == THE_INODE_IS_LOST)
            {
                $course[$course_id]['lost_inode'][$lost_inode_id] = $inode_id ;

                $lost_inode_id ++ ;
            }
        }


        ++ $course_id ;
    }


    //         list_lost_inodes_lost_chapitre_media.php
    $lost_with_no_cours_id['list_lost_inodes_lost_chapitre_media'] =
        list_lost_inodes_lost_chapitre_media ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_courses_files.php
    $lost_with_no_cours_id['list_lost_inodes_lost_courses_files'] =
        list_lost_inodes_lost_courses_files ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_inicrond_images.php
    $lost_with_no_cours_id['list_lost_inodes_lost_inicrond_images'] =
        list_lost_inodes_lost_inicrond_images ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_inicrond_texts.php
    $lost_with_no_cours_id['list_lost_inodes_lost_inicrond_texts'] =
        list_lost_inodes_lost_inicrond_texts ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_java_identifications_on_a_figure.php
    $lost_with_no_cours_id['list_lost_inodes_lost_java_identifications_on_a_figure'] =
        list_lost_inodes_lost_java_identifications_on_a_figure ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_tests.php
    $lost_with_no_cours_id['list_lost_inodes_lost_tests'] =
        list_lost_inodes_lost_tests ($_OPTIONS, $inicrond_db) ;

    //         list_lost_inodes_lost_virtual_directories.php
    $lost_with_no_cours_id['list_lost_inodes_lost_virtual_directories'] =
        list_lost_inodes_lost_virtual_directories ($_OPTIONS, $inicrond_db) ;

    $smarty->assign ('course', $course) ;
    $smarty->assign ('lost_with_no_cours_id', $lost_with_no_cours_id) ;
    $smarty->assign ('_LANG', $_LANG) ;

    $module_title = $_LANG['list_lost_inodes'] ;

    $module_content = $smarty->fetch ($_OPTIONS['theme'].'/list_lost_inodes.tpl') ;

}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>