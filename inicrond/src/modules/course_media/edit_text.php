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

define('__INICROND_INCLUDED__', true);
define('__INICROND_INCLUDE_PATH__', '../../');

include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__."modules/marks/includes/languages/".$_SESSION['language'].'/lang.php';
include "includes/functions/text_id_2_cours_id.php";//transfer IDs

if (is_numeric($_GET["text_id"]) && is_teacher_of_cours($_SESSION['usr_id'],  text_id_2_cours_id($_GET["text_id"])))
{
    include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_full_path.php';
    include 'includes/functions/text_id_2_inode_id.php';

    $module_content .= inode_full_path(text_id_2_inode_id($_GET["text_id"]));

    $module_title =  $_LANG['edit'];

    $query = "
    SELECT
    text_title,
    text_description
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
    WHERE
    text_id=".$_GET["text_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if (!isset($_POST['text_title']))
    {
        $smarty->assign('text_title', $fetch_result['text_title']);
        $smarty->assign('text_description', $fetch_result['text_description']);
        $smarty->assign("_LANG", $_LANG);

        $module_content .= $smarty->fetch($_OPTIONS['theme']."/text_form.tpl");
    }
    else // il y a eu envoi de données
    {
        if ($_POST['text_title'] == "")
        {
                $module_content .=  $_LANG['empty_string'];
        }

        else
        {
            include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
            SET
            text_title='".filter($_POST['text_title'])."',
            text_description='".filter($_POST['text_description'])."',
            edit_time_t=".inicrond_mktime()."
            WHERE
            text_id=".$_GET["text_id"]."
            ";

            $inicrond_db->Execute($query);

            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

            $query = "SELECT
            inode_id_location,
            cours_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
            WHERE
            text_id=".$_GET["text_id"]."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".$fetch_result['inode_id_location']."&cours_id=".$fetch_result['cours_id']);
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>