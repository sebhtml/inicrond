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

define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if(isset($_GET['file_id']) && $_GET['file_id'] != "" && (int) $_GET['file_id'])
{
    include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/conversion.function.php";

    $query = "
    SELECT
    md5_path,
    file_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
    WHERE
    file_id=".$_GET['file_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";
    include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/file_id_2_inode_id.php";

    if(is_in_inode_group($_SESSION['usr_id'], file_id_2_inode_id($_GET['file_id'])))//verify here...
    {
        include __INICROND_INCLUDE_PATH__."includes/kernel/update_online_time_inc.php";

        //insert the download

        $query = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
        (
        usr_id,
        session_id,
        file_id,
        gmt_ts
        )
        VALUES
        (
        ".$_SESSION['usr_id'].",
        ".$_SESSION['session_id'].",
        ".$_GET['file_id'].",
        ".inicrond_mktime()."
        )
        ";

        $inicrond_db->Execute ($query);

        header("Content-Disposition: attachment; filename=".$fetch_result['file_name']);
        header("Content-Type: application/force-download");
        header("Content-Transfer-Encoding: application/octet-stream\n"); // Surtout ne pas enlever le \n
        header("Content-Length: ".filesize($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["md5_path"]));
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
        header("Expires: 0");

        readfile($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["md5_path"]);//cotnenu du fichier

        $module_title = $fetch_result['file_name'] ;

        include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
    }
    else
    {
        echo "access denied";
    }
}

?>