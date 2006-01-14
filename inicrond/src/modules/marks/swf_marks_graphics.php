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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";

if(is_teacher_of_cours($_SESSION['usr_id'],chapitre_media_to_cours($_GET['chapitre_media_id'])s))
{
        $module_title =  $_LANG['swf_marks_graphics'];
        $module_content = "";

        //show some informations.
        $query = "
        SELECT
        chapitre_media_id,
        chapitre_media_title,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
        cours_code,
        cours_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id =  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media_id'].".inode_id
        and
        chapitre_media_id=".$_GET['chapitre_media_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        foreach($fetch_result AS $key => $value)
        {
            $module_content .= $_LANG[$key]. " : ".$value."<br />";
        }

        $module_content .= "<br /><br />";

        //images for all.
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/time_vs_score_img.php?chapitre_media_id=".$_GET['chapitre_media_id']."\" /><br /><br />";

        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_img.php?chapitre_media_id=".$_GET['chapitre_media_id']."\" /><br /><br />";

        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_time_img.php?chapitre_media_id=".$_GET['chapitre_media_id']."\" /><br /><br />";

        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/attempts_graphic.php?chapitre_media_id=".$_GET['chapitre_media_id']."\" /><br /><br />";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>