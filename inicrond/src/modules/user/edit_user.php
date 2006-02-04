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

include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
&& $_GET['usr_id'] == $_SESSION['usr_id'])
{
    $module_title = $_LANG['edit_my_profil'];

    //afficher profile modifier
    if(!isset($_POST['usr_nom']))
    {
        $query = "
        SELECT
        usr_name,
        language,
        usr_time_decal,
        usr_prenom,
        usr_nom,
        usr_signature,
        show_email,
        usr_email,
        usr_number
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $module_content .= "<form method=\"POST\" enctype=\"multipart/form-data\">";

        //email.
        $module_content .= $_LANG['usr_email']." : "."<input type=\"text\" name=\"usr_email\" value=\"". $fetch_result['usr_email']."\" /><br />";

        //show email.
        $module_content .= $_LANG['show_email']." : "."";
        $module_content .= $fetch_result['show_email'] ?
        "<select name=\"show_email\">
        <option SELECTED value=\"1\">".$_LANG['yes']."</option>
        <option value=\"0\">".$_LANG['no']."</option>
        </select>" ://the yes is selected.

        "<select name=\"show_email\">
        <option value=\"1\">".$_LANG['yes']."</option>
        <option SELECTED value=\"0\">".$_LANG['no']."</option>
        </select>"//the no is selected.
        ;
        $module_content .= "<br />";

        //prenom.
        $module_content .= $_LANG['usr_prenom']." : "."<input type=\"text\" name=\"usr_prenom\" value=\"". $fetch_result['usr_prenom']."\" /><br />";

        //nom
        $module_content .= $_LANG['usr_nom']." : "."<input type=\"text\" name=\"usr_nom\" value=\"". $fetch_result['usr_nom']."\" /><br />";

        //usr number
        $module_content .= $_LANG['usr_number']." : "."<input type=\"text\" name=\"usr_number\" value=\"". $fetch_result['usr_number']."\" /><br />";

        //usr_time_decal
        $module_content .= $_LANG['usr_time_decal']." : "."<select name=\"usr_time_decal\">";

        foreach ($_OPTIONS["txt_usr_time_decals"] as  $value)
        {
            $module_content .= "<option ".($value == $fetch_result['usr_time_decal'] ? "SELECTED" : "")." value=\"$value\">".$_LANG["txt_usr_time_decal_$value"]."</option>";
        }

        $module_content .= "</select>";

        $module_content .= "<br />";
        //languages
        $module_content .= $_LANG['language']." : "."<select name=\"language\">";

        foreach ($_OPTIONS['languages'] as  $value)
        {
            $module_content .= "<option ".($value == $fetch_result['language'] ? "SELECTED" : "")." value=\"$value\">$value</option>";
        }

        $module_content .= "</select>";

        $module_content .= "<br />";

        //usr signature.
        $module_content .= $_LANG['usr_signature']." : "."<textarea name=\"usr_signature\">".$fetch_result['usr_signature']."</textarea>";

        $module_content .= "<br />";
        //picture.
        $module_content .= $_LANG['usr_picture']." : "."<input type=\"file\" name=\"usr_picture\" />"."<br />".
        $_LANG['usr_pic_dimensions']." : ".$_OPTIONS['usr_pic_max_width']." x ".$_OPTIONS['usr_pic_max_height']."";
        $module_content .= "<br />";

        //remove picture.
        $module_content .= $_LANG['remove_picture']." : "."<input type=\"checkbox\" name=\"remove_picture\" />";
        $module_content .= "<br />";

        $module_content .= "<input type=\"submit\"></form>";
    }
    elseif (!preg_match($_OPTIONS['preg_email'], $_POST['usr_email']))
    {
        $module_content .=  $_LANG['error_email'];
    }
    else //on modifie !!!
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        SET
        usr_prenom='".filter($_POST['usr_prenom'])."',
        usr_nom='".filter($_POST['usr_nom'])."',
        usr_time_decal=".$_POST['usr_time_decal'].",
        usr_signature='".filter($_POST['usr_signature'])."',
        show_email='".$_POST['show_email']."',
        usr_number='".filter($_POST['usr_number'])."',
        usr_email='".filter($_POST['usr_email'])."',
        language='".$_POST['language']."'
        WHERE
        usr_id=".$_GET['usr_id']."
        LIMIT 1
        ";

        $inicrond_db->Execute($query);

        //session stuff.
        $_SESSION['language'] = $_POST['language'];
        $_SESSION['usr_time_decal'] = $_POST['usr_time_decal'];

        //get image path.
        $query = "
        SELECT
        usr_picture_file_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        ";

        $rs = $inicrond_db->Execute($query);

        $fetch_result = $rs->FetchRow();

        if (isset($_FILES['usr_picture']["tmp_name"]))
        {
            $info = getimagesize($_FILES['usr_picture']['tmp_name']) ;
        }

        // print_r ($info) ;

        if(isset ($info)
        && $info[0] <= $_OPTIONS['usr_pic_max_width']  //dimensions
        && $info[1] <= $_OPTIONS['usr_pic_max_height'])//remove the picture and add a new one...
        {
            if($fetch_result["usr_picture_file_name"] != "default1"
            && is_file($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["usr_picture_file_name"]))
            {
                //remove the old file
                unlink($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["usr_picture_file_name"]);
            }

            $HEXA_TAG = hex_gen_32 () ;//hexadecimal string

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            SET
            usr_picture_file_name='$HEXA_TAG'
            WHERE
            usr_id=".$_GET['usr_id']."
            ";

            $inicrond_db->Execute($query);

            copy($_FILES['usr_picture']["tmp_name"], $_OPTIONS["file_path"]["uploads"]."/".$HEXA_TAG);
        }

        if (isset($_POST['remove_picture']))//remove the picture
        {
            if ($fetch_result["usr_picture_file_name"] != "default1"
            && is_file($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["usr_picture_file_name"]))
            {
                unlink($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["usr_picture_file_name"]);
            }

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            SET
            usr_picture_file_name='default1'
            WHERE
            usr_id=".$_GET['usr_id']."
            ";

            $inicrond_db->Execute($query);
        }

        $module_content .=  $_LANG['profileModified' ];
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>