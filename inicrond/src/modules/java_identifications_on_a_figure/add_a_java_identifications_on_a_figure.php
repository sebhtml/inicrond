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

include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/transfert_cours.function.php' ;

if (is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id'])
&& (($_GET['inode_id_location'] == 0) || (inode_to_course($_GET['inode_id_location']) == $_GET['cours_id'])))
{

$module_title = $_LANG['add_a_java_identifications_on_a_figure'] ;

    //show the form
    if (!isset ($_POST['title']))
    {
        /*
            title
            image_file_name
            at_random : yes/no
            available_result : yes/no
            available_sheet : yes/no
        */

        $smarty->assign ('at_random', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('at_random_value', 0) ;

        $smarty->assign ('available_result', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('available_result_value', 0) ;

        $smarty->assign ('available_sheet', array (
                                        1 => $_LANG['yes'],
                                        0 => $_LANG['no']
                                         )) ;

        $smarty->assign ('available_sheet_value', 0) ;

        $smarty->assign ('_LANG', $_LANG) ;

        $module_content .= $smarty->fetch ($_OPTIONS['theme'].'/add_a_java_identifications_on_a_figure_form.tpl') ;
    }
    //add the stuff
    else
    {
        /*
            title
            image_file_name
            file_name_in_uploads
            at_random : yes/no
            available_result : yes/no
            available_sheet : yes/no
        */

        /*
            the real file name : $_FILES['uploaded_file']['name']
            the temporary file name : $_FILES['uploaded_file']['tmp_name']
        */
        include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

        $file_name_in_uploads = hex_gen_32();//hexadecimal string

        if (is_file ($_FILES['image_file_name']['tmp_name']))
        {
            copy($_FILES['image_file_name']['tmp_name'], $_OPTIONS["file_path"]["uploads"]."/".$file_name_in_uploads) ;
        }
        else
        {
            die ('incorrect file') ;
        }

        //insert the inode

        $query = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        (inode_id_location, cours_id)
        VALUES
        (".$_GET['inode_id_location'].", ".$_GET['cours_id'].")";

        $inicrond_db->Execute($query);

        $order_id = $inicrond_db->Insert_ID();

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        SET
        order_id=$order_id
        WHERE
        inode_id=$order_id
        " ;

        $inode_id = $order_id ;

        $inicrond_db->Execute($query);

        $add_time_t = $edit_time_t = inicrond_mktime();

        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $query = '
        insert into
        '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
        (
        inode_id,
        title,
        add_time_t,
        edit_time_t,
        image_file_name,
        at_random,
        available_result,
        available_sheet,
        file_name_in_uploads
        )
        values
        (
        '.$inode_id.',
        \''.filter($_POST['title']).'\',
        '.$add_time_t.',
        '.$edit_time_t.',
        \''.$_FILES['image_file_name']['name'].'\',
        \''.$_POST['at_random'].'\',
        \''.$_POST['available_result'].'\',
        \''.$_POST['available_sheet'].'\',
        \''.$file_name_in_uploads.'\'
        )
        ' ;

        $inicrond_db->Execute($query);

        // redirect to the place the person come from

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir (__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".
            $_GET['inode_id_location']."&cours_id=".$_GET['cours_id']);
    }
}


include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>