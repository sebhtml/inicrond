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

define('__INICROND_INCLUDED__', true) ;
define('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;
include 'includes/languages/'.$_SESSION['language'].'/lang.php' ;

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";    //function for access...


if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))
{
    if (!isset ($_POST['title']))
    {
        $query = '
        select
        title,
        at_random,
        available_result,
        available_sheet
        from
        '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
        where
        inode_id = '.$_GET['inode_id'].'
        ' ;

        $rs = $inicrond_db->Execute ($query) ;
        $row = $rs->FetchRow () ;

        $smarty->assign ('title', $row['title']) ;

        $smarty->assign ('at_random', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('at_random_value', $row['at_random']) ;

        $smarty->assign ('available_result', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('available_result_value', $row['available_result']) ;

        $smarty->assign ('available_sheet', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('available_sheet_value', $row['available_sheet']) ;

        $smarty->assign ('_LANG', $_LANG) ;

        $module_content .= $smarty->fetch ($_OPTIONS['theme'].'/edit_a_java_identifications_on_a_figure_form.tpl') ;
    }
    else
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $query = '
        update
        '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
        set
        title = \''.filter ($_POST['title']).'\',
        at_random = \''.$_POST['at_random'].'\',
        available_result = \''.$_POST['available_result'].'\',
        available_sheet = \''.$_POST['available_sheet'].'\'
        where
        inode_id = '.$_GET['inode_id'].'
        ' ;

        $inicrond_db->Execute ($query) ;

        if (is_file ($_FILES['image_file_name']['tmp_name']))
        {
            $query = '
            select
            file_name_in_uploads
            from
            '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
            where
            inode_id = '.$_GET['inode_id'].'
            ' ;

            $rs = $inicrond_db->Execute ($query) ;
            $row = $rs->FetchRow () ;

            $file_name_in_uploads = $row['file_name_in_uploads'] ;

            copy($_FILES['image_file_name']['tmp_name'], $_OPTIONS["file_path"]["uploads"]."/".$file_name_in_uploads) ;

            $query = '
            update
            '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
            set
            image_file_name = \''.filter ($_FILES['image_file_name']['name']).'\'
            where
            inode_id = '.$_GET['inode_id'].'
            ' ;

            $inicrond_db->Execute ($query) ;
        }

        $query = '
        select
        cours_id,
        inode_id_location
        from
        '.$_OPTIONS['table_prefix'].'inode_elements
        where
        inode_id = '.$_GET['inode_id'].'
        ' ;

        $rs = $inicrond_db->Execute ($query) ;
        $row = $rs->FetchRow () ;

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir (__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".
            $row['inode_id_location']."&cours_id=".$row['cours_id']);
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>