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

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";


if(isset($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_in_inode_group ($_SESSION['usr_id'], $_GET['inode_id']))
{
    include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/conversion.function.php";

    $query = "
    SELECT
    file_name_in_uploads,
    image_file_name
    FROM
    ".$_OPTIONS['table_prefix']."java_identifications_on_a_figure
    WHERE
    inode_id=".$_GET['inode_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    header("Content-Disposition: attachment; filename=".$fetch_result['image_file_name']);
    //header("Content-Type: application/force-download");
    //header("Content-Transfer-Encoding: application/octet-stream\n"); // Surtout ne pas enlever le \n
    header("Content-Length: ".filesize($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["file_name_in_uploads"]));
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
    header("Expires: 0");

    readfile($_OPTIONS["file_path"]["uploads"]."/".$fetch_result["file_name_in_uploads"]);//cotnenu du fichier

    $module_title = $fetch_result['image_file_name'] ;

    include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
}

?>