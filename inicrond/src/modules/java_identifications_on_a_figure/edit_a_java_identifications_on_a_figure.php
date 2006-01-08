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

    if (isset ($_POST['title']))
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


        include 'includes/functions/java_identifications_on_a_figure_label_id_to_inode_id.php' ;

        foreach ($_POST AS $key => $value)//pour chaque donn�ss.
        {
            if(preg_match("/java_identifications_on_a_figure_label_id=(.+)&label_name/", $key, $tokens) //les txt pour questions
            && (java_identifications_on_a_figure_label_id_to_inode_id ($tokens["1"], $_OPTIONS, $inicrond_db) == $_GET['inode_id']))
            {
                $query = "
                UPDATE
                ".$_OPTIONS["table_prefix"]."java_identifications_on_a_figure_label
                SET
                label_name='".filter($value)."'
                WHERE
                java_identifications_on_a_figure_label_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/java_identifications_on_a_figure_label_id=(.+)&x_position/", $key, $tokens) //les txt pour questions
            && (java_identifications_on_a_figure_label_id_to_inode_id ($tokens["1"], $_OPTIONS, $inicrond_db) == $_GET['inode_id']))
            {
                $query = "
                UPDATE
                ".$_OPTIONS["table_prefix"]."java_identifications_on_a_figure_label
                SET
                x_position='".filter($value)."'
                WHERE
                java_identifications_on_a_figure_label_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/java_identifications_on_a_figure_label_id=(.+)&y_position/", $key, $tokens) //les txt pour questions
            && (java_identifications_on_a_figure_label_id_to_inode_id ($tokens["1"], $_OPTIONS, $inicrond_db) == $_GET['inode_id']))
            {
                $query = "
                UPDATE
                ".$_OPTIONS["table_prefix"]."java_identifications_on_a_figure_label
                SET
                y_position='".filter($value)."'
                WHERE
                java_identifications_on_a_figure_label_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
        }
    }

    // shwo the form

    $query = '
    select
    title,
    at_random,
    available_result,
    available_sheet,
    file_name_in_uploads,
    image_file_name
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
    where
    inode_id = '.$_GET['inode_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $file_name_in_uploads = $row['file_name_in_uploads'] ;
    $image_file_name = $row['image_file_name'] ;

    $smarty->assign ('inode_id', $_GET['inode_id']) ;

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

    // get the labels...

    $query = '
    select
    java_identifications_on_a_figure_label_id,
    label_name,
    x_position,
    y_position
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    where
    inode_id = '.$_GET['inode_id'].'
    order by order_id asc
    ' ;

    $rs = $inicrond_db->Execute ($query) ;

    $java_identifications_on_a_figure_label = array () ;

    while ($row = $rs->FetchRow ())
    {
        $java_identifications_on_a_figure_label [] = $row ;
    }

    $smarty->assign ('java_identifications_on_a_figure_label', $java_identifications_on_a_figure_label) ;

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


    $infos  = getimagesize($_OPTIONS["file_path"]["uploads"]."/".$file_name_in_uploads);

    $image_width = $infos[0];

    $image_height = $infos[1];

    $smarty->assign ('image_width', $image_width) ;
    $smarty->assign ('image_height', $image_height) ;

    $smarty->assign ('image_file_name', $image_file_name) ;

    $module_title = $_LANG['edit_a_java_identifications_on_a_figure'] ;

    $module_content .= $smarty->fetch ($_OPTIONS['theme'].'/edit_a_java_identifications_on_a_figure_form.tpl') ;
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>