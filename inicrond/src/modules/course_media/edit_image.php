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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');

include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__."modules/marks/includes/languages/".$_SESSION['language'].'/lang.php';
include "includes/functions/img_id_2_cours_id.php";//transfer IDs

if (is_numeric($_GET["img_id"]) && is_teacher_of_cours($_SESSION['usr_id'],  img_id_2_cours_id($_GET["img_id"])))
{
    include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_full_path.php';
    include 'includes/functions/img_id_2_inode_id.php';

    $module_content .= inode_full_path(img_id_2_inode_id($_GET["img_id"]));

    $module_title =  $_LANG['edit'];

    $query = "
    SELECT
    img_title,
    img_description,
    img_hexa_path
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
    WHERE
    img_id=".$_GET["img_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if(!isset($_POST['img_title']))
    {
        $smarty->assign('img_title', $fetch_result['img_title']);
        $smarty->assign('img_description', $fetch_result['img_description']);
        $smarty->assign("_LANG", $_LANG);

        $module_content .= $smarty->fetch($_OPTIONS['theme']."/image_form.tpl");
    }
    else // il y a eu envoi de données
    {
        if ($_POST['img_title'] == '')
        {
            $module_content .=  $_LANG['empty_string'];
        }

        else
        {
            include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            SET
            img_title='".filter($_POST['img_title'])."',
            img_description='".filter($_POST['img_description'])."',
            edit_time_t=".inicrond_mktime()."
            WHERE
            img_id=".$_GET["img_id"]."
            ";

            $inicrond_db->Execute($query);

            if (is_file($_FILES['img_file_name']['tmp_name']))//UPDATE THE FILE???????.
            {
                $infos  = getimagesize($_FILES['img_file_name']['tmp_name']);

                $chapitre_media_width = $infos["0"];//pour flash

                $chapitre_media_height = $infos["1"];//pour flash

                if (!copy($_FILES['img_file_name']['tmp_name'],                 $_OPTIONS["file_path"]["uploads"]."/".$fetch_result["img_hexa_path"]))
                {
                    die($_LANG['error_file']);
                }

                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
                SET
                img_file_name='".$_FILES['img_file_name']['name']."'
                WHERE
                img_id=".$_GET["img_id"]."
                ";

                $inicrond_db->Execute($query);

            }//end of update the file.


            $query = "
            SELECT
            inode_id_location,
            cours_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            WHERE
            img_id=".$_GET["img_id"]."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].".inode_id
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

            js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".$fetch_result['inode_id_location']."&cours_id=".$fetch_result['cours_id']);
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>